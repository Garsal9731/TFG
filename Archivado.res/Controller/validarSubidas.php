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

function analizarAPI($idArchivo){

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

    // Si el analisis no se ha completado se recarga la página
    if($analisis["data"]["attributes"]["status"] !== "completed"){
      // ! Añadir mensajes de analisis (analizando archivo (nombre))
      header("Refresh:2");
    }
    $maliciosos = $analisis["data"]["attributes"]["stats"]["malicious"];
    $sospechosos = $analisis["data"]["attributes"]["stats"]["suspicious"];
    $noDetectado = $analisis["data"]["attributes"]["stats"]["undetected"];
    $seguro = $analisis["data"]["attributes"]["stats"]["harmless"];
    $noAnalizado = $analisis["data"]["attributes"]["stats"]["failure"];
    $resultados = array("malicioso"=>$maliciosos,"sospechoso"=>$sospechosos,"noDetectado"=>$noDetectado,"seguro"=>$seguro,"fallo"=>$noAnalizado);
    return $resultados;
  }
}

require '../Model/usuario.php';

// ! SUBIR LOS ARCHIVOS Y ADAPTARLOS A EL ESQUEMA DE LA BASE DE DATOS
echo "<pre>";
    var_dump($_FILES["archivos"]);
echo "</pre>";
echo "<br>";
echo "-------------------------------<br>";

// Comprobamos que las cookies están creadas
if(!isset($_COOKIE["nombresTemporales"])){

  // Preestablecemos arrays y guardamos partes del nombre provisional en ellos
  $nombresTemporales = array();
  foreach($_FILES["archivos"]["tmp_name"] as $archivo){
  
    $nombreTemporal = explode("/",$archivo)[count(explode("/",$archivo))-1];
    array_push($nombresTemporales, $nombreTemporal);
  }
  
  $extensiones = array();
  foreach($_FILES["archivos"]["name"] as $nombreArchivo){
    $extension = pathinfo($nombreArchivo, PATHINFO_EXTENSION);

    // Añadimos al array la ultima posición del array (sería la extension del archivo) junto a un punto
    array_push($extensiones,".".$extension);
  }

  // Preestablecemos los arrays
  $nombresCompletos = array();
  $idsArchivos = array();

  // Creamos un contador para recoger todos los archivos y guardarlos en la cuarentena con sus nombres temporales
  for($contador=0; $contador<count($_FILES["archivos"]["name"]); $contador++){
    $nombre = $nombresTemporales[$contador].$extensiones[$contador];
    array_push($nombresCompletos,$nombre);

    if(move_uploaded_file($_FILES['archivos']['tmp_name'][$contador],"../cuarentena/$nombre")){
      echo "Se ha subido el archivo ".$nombre."<br>";
    }else{
      echo "NO SE HA PODIDO SUBIR EL ARCHIVO A LA CUARENTENA<br>";
    }

    $datos = file_get_contents($ruta);
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

  // Refrescamos la página
  header("Refresh:0");

}else{
  var_dump($_COOKIE["nombresTemporales"]);
  echo "<br>";
  var_dump($_COOKIE["idsAnalisis"]);
  echo "<br>";
  $nombresTemporales = json_decode($_COOKIE["nombresTemporales"]);
  $arrayIds = json_decode($_COOKIE["idsAnalisis"]);
}

  for($contador=0; $contador<count($arrayIds); $contador++){
    $resultados = analizarAPI($arrayIds[$contador]);

    var_dump($resultados);
    echo "<br>";

    // ! una vez analizado todo borrar los archivos de cuarentena y registrar en la base de datos con sus nombres originales y una id

    // Si da afirmativo la detección o falla el analisis
    if($resultados["malicioso"]!==0 || $resultados["sospechoso"]!==0 || $resultados["fallo"]!==0){
      echo "<p>El archivo ".$_FILES["archivos"]["name"][$contador]." no se ha podido analizar o a dado positivo como amenaza.</p>";
      echo "<p>Crea un ticket para su revisión con el nombre temporal <strong>".$nombresTemporales[$contador]."</strong> y el asunto <strong>REVISIÓN DE ARCHIVO</strong></p>";
    }else{
      
      $nombre = $_FILES['archivos']['name'][$contador];
      if(move_uploaded_file($_FILES['archivos']['tmp_name'][$contador],"../subidas/$nombre")){
        echo "¡Se ha subido el archivo ".$nombre."!<br>";

        // Borramos el archivo temporal de la cuarentena
        unlink("../cuarentena/".$nombresTemporales[$contador]);

        // ! REGISTRAR EN LA BASE DE DATOS Y CAMBIAR EL NOMBRE DE GUARDADO POR LA ID
      }else{
        echo "NO SE HA PODIDO SUBIR EL ARCHIVO<br>";
      }
      
    }

  }

echo "<br><br><br>";


// header('Location: index.php');
// die();