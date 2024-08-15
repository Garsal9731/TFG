<?php

  function subirAPI($nombre, $tipoArchivo, $cifrado){

    $curl = curl_init();

    curl_setopt_array($curl, [
      CURLOPT_URL => "https://www.virustotal.com/api/v3/files",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => "-----011000010111000001101001\r\nContent-Disposition: form-data; name=\"file\"; filename=\"$nombre\"\r\nContent-Type: $tipoArchivo\r\n\r\ndata:$tipoArchivo;name=$nombre;base64,$cifrado\r\n-----011000010111000001101001--",
      CURLOPT_HTTPHEADER => [
        "accept: application/json",
        "content-type: multipart/form-data; boundary=---011000010111000001101001",
        "x-apikey: 69beef14b62f6b656eca6d197752ea8e4d160fc29c7f1374a095f7b19b235114"
      ],
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
      echo "cURL Error #:" . $err;
    } else {

      $responseArray = json_decode($response, true);

      $idArchivo = $responseArray["data"]["id"];
      return $idArchivo;
    }
  }

  function analizarAPI($idArchivo,$nombre,$nombreTemporal){

    $curl = curl_init();

    curl_setopt_array($curl, [
      CURLOPT_URL => "https://www.virustotal.com/api/v3/analyses/$idArchivo",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_HTTPHEADER => [
        "accept: application/json",
        "x-apikey: 69beef14b62f6b656eca6d197752ea8e4d160fc29c7f1374a095f7b19b235114"
      ],
    ]);
    
    $response = curl_exec($curl);
    $err = curl_error($curl);
    
    curl_close($curl);
    
    if ($err){
      echo "cURL Error #:" . $err;
    } else {
      $analisis = json_decode($response, true);

      if(isset($analisis["error"])){
        echo "<p>El archivo ".$nombre." no se ha podido analizar o a dado positivo como amenaza.</p>";
        echo "<p>Crea un ticket para su revisión con el nombre temporal <strong>".$nombreTemporal."</strong> y el asunto <strong>REVISIÓN MANUAL DE ARCHIVO</strong>.</p>";

        if(isset($_COOKIE["idsAnalisis"])){
          setcookie("idsAnalisis",'',-1, "/");    
        }
        if(isset($_COOKIE["nombresOriginales"])){
          setcookie("nombresOriginales",'',-1, "/");
        }

        // ! CREAR UN SISTEMA DE AVISOS PARA MANDAR ESTE AVISO
        // ! AÑADIR ENLACE DE TICKETS DIRECTOS CUANDO HAYA SIDO CREADO EL SISTEMA DE TICKETS
        // ! CREAR SISTEMA DE INTENTOS PARA NO SOBRECARGAR LA PAGINA EN CASO DE FALLO
      }else{

        // Si el analisis no se ha completado se recarga la página
        if($analisis["data"]["attributes"]["status"] !== "completed"){
          echo "<p>Analizando el archivo ".$nombre."...... (Este proceso podría tardar un poco).</p>";
          header("Refresh:2");
          die();
        }else{
          $maliciosos = $analisis["data"]["attributes"]["stats"]["malicious"];
          $sospechosos = $analisis["data"]["attributes"]["stats"]["suspicious"];
          $noDetectado = $analisis["data"]["attributes"]["stats"]["undetected"];
          $seguro = $analisis["data"]["attributes"]["stats"]["harmless"];
          $noAnalizado = $analisis["data"]["attributes"]["stats"]["failure"];
          $resultados = array("malicioso"=>$maliciosos,"sospechoso"=>$sospechosos,"noDetectado"=>$noDetectado,"seguro"=>$seguro,"fallo"=>$noAnalizado);
          return $resultados;
        }
      }

    }
  }

  session_start();

  require '../Model/archivo.php';

  // Comprobamos que las cookies están creadas
  if(!isset($_COOKIE["nombresTemporales"])){

    // Preestablecemos arrays y guardamos partes del nombre provisional en ellos
    $nombresTemporales = array();
    foreach($_FILES["archivos"]["tmp_name"] as $archivo){
    
      $nombreTemporal = explode("/",$archivo)[count(explode("/",$archivo))-1];
      array_push($nombresTemporales, $nombreTemporal);
    }
    
    $extensiones = array();
    $nombresOriginales = array();
    foreach($_FILES["archivos"]["name"] as $nombreArchivo){
      $extension = pathinfo($nombreArchivo, PATHINFO_EXTENSION);

      // Añadimos al array la ultima posición del array (sería la extension del archivo) junto a un punto
      array_push($extensiones,".".$extension);
      array_push($nombresOriginales,$nombreArchivo);
    }

    // Preestablecemos los arrays
    $nombresCompletos = array();
    $idsArchivos = array();

    // Creamos un contador para recoger todos los archivos y guardarlos en la cuarentena con sus nombres temporales
    for($contador=0; $contador<count($_FILES["archivos"]["name"]); $contador++){
      $nombre = $nombresTemporales[$contador].$extensiones[$contador];
      array_push($nombresCompletos,$nombre);

      if(move_uploaded_file($_FILES['archivos']['tmp_name'][$contador],"../cuarentena/$nombre")){
        echo "Se ha subido el archivo temporal: ".$nombre."<br>";
      }else{
        echo "NO SE HA PODIDO SUBIR EL ARCHIVO A LA CUARENTENA<br>";
      }

      $datos = file_get_contents("../cuarentena/$nombre");
      $cifrado = base64_encode($datos);

      $tipoArchivo = $_FILES["archivos"]["type"][$contador];

      // La API tiene un limite de subida de 4 archivos el minuto (el primer archivo es el 0), asi que retrasamos el programa 1 minuto
      if($contador%3==0){
        sleep(60);
      }

      // Subimos el archivo a la API y nos quedamos con el identificador del analisis
      $idArchivo = subirAPI($nombre, $tipoArchivo, $cifrado);

      array_push($idsArchivos,$idArchivo);

    }

    // Creamos cookies para mantener los datos
    setcookie("nombresTemporales", json_encode($nombresCompletos), time() + (86400 * 30), "/");
    setcookie("idsAnalisis", json_encode($idsArchivos), time() + (86400 * 30), "/");
    setcookie("nombresOriginales", json_encode($nombresOriginales), time() + (86400 * 30), "/");

    // Refrescamos la página
    header("Refresh:0");

  }else{
    $nombresTemporales = json_decode($_COOKIE["nombresTemporales"]);
    $nombresOriginales = json_decode($_COOKIE["nombresOriginales"]);
    $arrayIds = json_decode($_COOKIE["idsAnalisis"]);
  }

  for($contador=0; $contador<count($arrayIds); $contador++){

    $nombre = $nombresOriginales[$contador];
    $nombreTemporal = $nombresTemporales[$contador];

    echo "<p>NOMBRE: ".$nombre."</p>";
    $resultados = analizarAPI($arrayIds[$contador],$nombre,$nombreTemporal);

    if($resultados!==NULL){
      // Si da afirmativo la detección o falla el analisis
      if($resultados["malicioso"]!==0 || $resultados["sospechoso"]!==0 || $resultados["fallo"]!==0){
        echo "<p>El archivo ".$_FILES["archivos"]["name"][$contador]." no se ha podido analizar o a dado positivo como amenaza.</p>";
        echo "<p>Crea un ticket para su revisión con el nombre temporal <strong>".$nombreTemporal."</strong> y el asunto <strong>REVISIÓN MANUAL DE ARCHIVO</strong></p>";
        // ! AÑADIR BOTON DE TICKET PARO LA REVISION DEL ARCHIVO
      }else{
        
        echo "<p>¡ANALISIS COMPLETADO!</p>";

        $arrayIdsArchivo = array();

        $idUsuario = $_SESSION["idusuario"];

        // Sacamos la extensión
        $extension = ".".explode(".",$nombre)[1];

        // Registramos el archivo
        $archivo = new Archivo("0",$idUsuario,$extension,"ruta",$nombre);
        $archivo->registrar();

        // Sacamos su ID
        $ultimaId = Archivo::ultimaId();

        array_push($arrayIdsArchivo,$ultimaId);

        $nombreSubida = $ultimaId.$extension; 

        $ruta = "../subidas/".$nombreSubida;

        Archivo::cambiarRutaId($ruta,$ultimaId);

        // Si existe el archivo no se subirá
        if(file_exists("../subidas/".$nombreSubida)){
          echo "<p>¡EL ARCHIVO YA HA SIDO SUBIDO!</p>";
          Archivo::borrarPorId($ultimaId);

        }else{

          // Para evitar consumo extra movemos el archivo temporal de la cuarentena a la subida y lo renombramos
          if(rename("../cuarentena/".$nombreTemporal,"../subidas/".$nombreSubida)){
            echo "<p>¡Se ha subido el archivo ".$nombre."!</p>";

          }else{
            echo "NO SE HA PODIDO SUBIR EL ARCHIVO<br>";
            Archivo::borrarPorId($ultimaId);
          }
        }
      }
    }
  }

  // Borramos las cookies usadas
  if(isset($_COOKIE["nombresTemporales"])){
    setcookie("nombresTemporales",'',-1, "/");
  }
  if(isset($_COOKIE["idsAnalisis"])){
    setcookie("idsAnalisis",'',-1, "/");    
  }
  if(isset($_COOKIE["nombresOriginales"])){
    setcookie("nombresOriginales",'',-1, "/");
  }

  if($resultados!==null){
    setcookie("idsArchivos",json_encode($arrayIdsArchivo),time() + (86400 * 30), "/");

    echo '<a href="crearPost.php"><button>Ir al formulario</button></a>';
  }