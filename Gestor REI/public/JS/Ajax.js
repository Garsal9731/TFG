// Por defecto en carga de la pagina lanzará una busqueda para recoger todos los resultados y mostrarlos, esto es necesario ya que quiero que por defecto se muestren todos los resultados al cargar la página (NO HAY OTRA MANERA DE HACERLO)
let clase = document.location["href"].split("=")[1].split("/")[0];
let tabla = null;
switch (clase) {
    case "user":

        // Si estamos en la página de permisos de los usuarios cambiamos la busqueda para que sean los permisos
        if (document.location["href"].split("=")[1].split("/")[1]=="manage") {
            tabla = 'Permisos';
        }else{
            tabla = 'Usuario';
        }
        break;
    case "item":
        tabla = 'Objeto';
        break;
    case "inst":
        tabla = 'Institucion';
        break;
    case "task":
        
        // Sacamos el tipo de letra, ya que al dividirse en otras páginas puede ocurrir errores de no dividirse la query de busqueda
        let tipoTarea = document.location["href"].split("=")[1].split("/")[1];
            switch(tipoTarea){
                case "index":
                    tabla = 'TareaP';
                    break;
                case "completed":
                    tabla = 'TareaC';
                    break;
                case "created":
                    tabla = 'TareaD';
                    break; 
                case "all&id":
                    tabla = 'TareaU';
                    break;
            }
        break;
}

// Recogemos el icono de la lupa y le damos un evento para buscar usando el valor escrito del buscador
let lupa = document.getElementById("lupa");
lupa.style.cursor = "pointer";
lupa.addEventListener("click",function() {
  buscarAjax(tabla);
});

function keyListener(event){ 

    // Recogemos y capturamos el evento y la tecla que se ha pulsado
    event = event || window.event;
    var key = event.key || event.which || event.keyCode;

    // Si la tecla tocada es la tecla "Enter" buscamos en la tabla de esta página con el ajax
    if(key=="Enter"){
        buscarAjax(tabla);
    }
}

// Cuando cargue la página activa la busqueda del ajax automaticamente
window.onload=buscarAjax(tabla);
      
// Recogemos el elemnto al que vamos a añadir el evento
var buscador = document.getElementById("buscador");
    
// Le damos un nombre al evento
var eventName = 'keypress';
      
// Añadimos un evento con addEventListener y con attachEvent en caso de que no funcionase (Inclusividad de Edge) y llamamos a la función
if (buscador.addEventListener) {
    buscador.addEventListener(eventName, keyListener, false); 
}else if (el.attachEvent){
    buscador.attachEvent('on'+eventName, keyListener);
}

// Tareas al ser 2 campos diferentes usan distintas IDs y para evitar problemas con las otras paginas hay un por defecto, esto ayuda a visualizar los resultados del ajax
function sacarParrafoResultados(letra){
    if(document.getElementById("resultados_busqueda")){     
        var parrafoResultados = "resultados_busqueda";
        
    }else{
        switch (letra) {
            case "P":
                var parrafoResultados = "resultados_busqueda_P";
                break;
            case "C":
                var parrafoResultados = "resultados_busqueda_C";
                break;
            case "D":
                var parrafoResultados = "resultados_busqueda_D";
                break;
            case "U":
                var parrafoResultados = "resultados_busqueda_U";
                document.cookie = "userSearch="+document.location["href"].split("=")[2]+";expires=Thu, 18 Dec 3000 12:00:00 UTC; path=/"; 
                break;
        }
    }
    return parrafoResultados
}

async function buscarAjax(tabla){

    // Recogemos del buscador el valor a buscar del buscador
    let hilo = document.getElementById("buscador").value;
    
    // Sacamos la letra del parrafo que vamos a usar para mostrar los resultados (Si son la pagina de Tareas), si no lo es lo dejamos nulo para poder sacar la respuesta por defecto
    if(tabla=="TareaP" || tabla=="TareaC" || tabla=="TareaD" || tabla=="TareaU"){
        letra = tabla.split("",6)[5];
    }else{
        letra = null;
    }

    // Sacamos el parrafo de los resultados usando la letra
    let parrafoResultados = sacarParrafoResultados(letra);

    // Comprobamos si los resultados están visibles y si lo están los ponemos invisibles
    if (document.getElementById(parrafoResultados).className=="visible") {
        document.getElementById(parrafoResultados).setAttribute("class","invisible");
    }

    // Si el hilo está vacio o es 0 mostramos vacío el buscador en el que vamos a colocar los datos y no buscamos 
    if(hilo.length == 0 || hilo==null){ 
        hilo = "%";
    }

    // Comprobamos si hay resultados para borrarlos y renovarlos
    if (document.getElementsByClassName("resultado")){

        // Comprobamos que en los resultados hay un primer hijo, de haberlo borramos el ultimos hijo (esto borrará todos los hijos, ya que el primero acabará siendo el ultimo)
            while (document.getElementById(parrafoResultados).firstChild) {
                document.getElementById(parrafoResultados).removeChild(document.getElementById(parrafoResultados).lastChild);
            }
    }

    // Enviamos la petición por get al php que tiene la busqueda del ajax
    fetch("../app/core/ajax.php?peticion="+hilo+"&tabla="+tabla)
    .then((respuesta) => {

        // Comprobamos que hay respuesta de la promesa enviada, de no haberla o dar error soltará este mensaje
        if(!respuesta.ok){ 
            throw new Error("No se ha podido buscar.");
        }

        // Devolvemos la respuesta codificada en JSON
        return respuesta.json();
    })
    .then(async (resultado) => {

        // Cambiamos la tabla a Tarea a secas (la letra se usa como un identificador para el ajax, a estas alturas ya tenemos el resultado asi que es mejor generalizar como "Tareas" a secas)
        if(tabla=="TareaP" || tabla=="TareaC" || tabla=="TareaD" || tabla=="TareaU"){
            tabla = "Tarea";
        }

        // En caso de que el resultado salga vacío debido a una falta de datos en la BD mostramos este mensaje
        if(resultado.length==0){
            let mensaje = document.createElement("p");
            mensaje.textContent = "No se ha encontrado nada.";
            mensaje.setAttribute("class","mensaje");
            document.getElementById(parrafoResultados).append(mensaje);
        }

        // Tratamos cada resultado generado
        resultado.forEach(dato => {

            // Sacamos los indices del array resultante de la consulta y preestablecemos variables
            let claves = Object.keys(dato);

            // En caso de que los indices vengan mezclados (limitaciones de fetchall en php y otras cosas), filtramos los indices asociativos y eliminamos los indices númericos para evitar repeticiones innecesarias
            for (let index = 0; index < claves.length; index++) {
                if(!isNaN(claves[index])){
                    delete claves[index];
                }
            }
            claves = claves.flat();

            // Preestablecemos variables
            let texto = "";
            let id = 0;
            let enlace_edit = "";
            let enlace_elim = "";

            // Recogemos los datos usando sus claves para poder juntarlos en un solo texto
            claves.forEach(clave => {
                if(clave.includes("Id")||clave.includes("id")){
                    id = dato[clave];
                }else{
                    
                    if (clave!=="Foto"){
                        // Si la clave es igual a la ultima clave no añade espacio, en cualquier otro caso si añadirá espacio
                        if (clave==claves.length-1) {
                            texto = texto.concat(dato[clave]);
                        }else{
                            texto = texto.concat(dato[clave]+" ");
                        }
                    }
                }
            });

            // Creamos el parrafo con el resultado creado
            let parrafo = document.createElement("p");
            if(tabla=="Objeto"){
                parrafo.className = "resultadoObjeto";
            }else{
                parrafo.className = "resultado";
            }

            // Creamos un div donde meter los enlaces
            let div = document.createElement("div");
            div.setAttribute("class","divBotones");

            enlace_edit = document.createElement("a");
            enlace_elim = document.createElement("a");
            enlace_elim.textContent = "Eliminar";
            enlace_elim.setAttribute("class","eliminar");

            // Dependiendo de la tabla cambiamos algunos elementos
            switch (tabla) {
                case "Usuario":

                    parrafo.textContent = texto;
                    enlace_edit.textContent = "Editar";

                    // Creamos los enlaces de editar y borrar el usuario, les damos el enlace y un texto
                    enlace_edit.setAttribute("href","index.php?route=user/edit&id="+id);
                    enlace_elim.setAttribute("href","index.php?route=user/delete&id="+id);

                    enlace_stats = document.createElement("a");
                    enlace_stats.setAttribute("href","index.php?route=user/stats&id="+id);
                    enlace_stats.textContent = "Ver Stats.";
                    
                    // Los metemos en el parrafo que hemos creado
                    div.append(enlace_stats,enlace_edit,enlace_elim);

                    // Añadimos el div con los botones creados al parrafo
                    parrafo.append(div);
                    break;
                case "Permisos":
                    textoPermiso = texto.split(" ")[0]+" manda a "+texto.split(" ")[1]
                    parrafo.textContent = textoPermiso;

                    // Creamos un enlace en caso de que sea necesario borrar el permiso del usuario
                    enlace_elim.setAttribute("href","index.php?route=permits/delete&jefe="+dato["Id_Jefe"]+"&empleado="+dato["Id_Usuario"]);
                    
                    // Los metemos en el parrafo que hemos creado
                    div.append(enlace_elim);

                    // Añadimos el div con los botones creados al parrafo
                    parrafo.append(div);
                    break;
                case "Objeto":
        
                    parrafo.textContent = texto;
                    enlace_edit.textContent = "Editar";

                    if(dato["Foto"]!=="no"){
                        foto = document.createElement("img");
                        foto.setAttribute("class","fotoObjeto");
                        foto.setAttribute("alt","Foto Objeto");
                        foto.setAttribute("src","IMG/items/"+dato["Foto"]);
                    }else{
                        foto = document.createElement("img");
                        foto.setAttribute("class","fotoObjeto");
                        foto.setAttribute("alt","Foto Objeto");
                        foto.setAttribute("src","https://upload.wikimedia.org/wikipedia/commons/6/65/No-Image-Placeholder.svg");
                    }

                    // Creamos los enlaces de editar y borrar el usuario, les damos el enlace y un texto
                    enlace_edit.setAttribute("href","index.php?route=item/edit&id="+id);
                    enlace_elim.setAttribute("href","index.php?route=item/delete&id="+id);
                    
                    // Los metemos en el parrafo que hemos creado
                    div.append(enlace_edit,enlace_elim);

                    // Añadimos el div con los botones creados al parrafo
                    parrafo.append(foto,div);
                    
                    break;
                case "Tarea":
                    div_cuerpo = document.createElement("div");
                    div_cuerpo.setAttribute("class","cuerpoTarjeta");

                    claves.forEach(clave => {
                        switch (clave) {
                            case "Nombre_Tarea":
                                div_cabecera = document.createElement("div");
                                div_cabecera.setAttribute("class","cabecera");

                                titulo = document.createElement("h3");
                                titulo.textContent = dato[clave];
                                div_cabecera.append(titulo);
                                break;
                            case "Nombre":
                                parrafoNombre = document.createElement("p");
                                parrafoNombre.setAttribute("class","parrafoNombre");

                                label = document.createElement("label");
                                label.setAttribute("for","nombre");
                                label.textContent = "Creador de la Tarea:";

                                nombre = document.createElement("h5");
                                nombre.textContent = dato[clave];

                                parrafoNombre.append(label,nombre);

                                break;
                            case "Nombre_Usuario":
                                parrafoNombre = document.createElement("p");
                                parrafoNombre.setAttribute("class","parrafoNombre");

                                label = document.createElement("label");
                                label.setAttribute("for","nombre");
                                label.textContent = "Creador de la Tarea:";

                                nombre = document.createElement("h5");
                                nombre.textContent = dato[clave];

                                parrafoNombre.append(label,nombre);

                                break;
                            case "Detalles":
                                parrafoDesc = document.createElement("p");
                                parrafoDesc.setAttribute("class","parrafoDesc");

                                label = document.createElement("label");
                                label.setAttribute("for","descripcion");
                                label.textContent = "Detalles de la tarea:";

                                descripcion = document.createElement("textarea");
                                descripcion.setAttribute("id","descripcion");
                                descripcion.setAttribute("readonly","");
                                descripcion.textContent = dato[clave];

                                parrafoDesc.append(label,descripcion);
                                break;
                        }
                    });
            
                    enlace_edit.textContent = "Revisar";

                    if(parrafoResultados=="resultados_busqueda_U"){
                        enlace_edit.setAttribute("href","index.php?route=task/check&id="+dato[0]);
                    }else{
                        enlace_edit.setAttribute("href","index.php?route=task/check&id="+id);
                    }

                    if(parrafoResultados=="resultados_busqueda_D"){
                        enlace_edit = document.createElement("div");
                        botonEditar = document.createElement("a");
                        botonBorrar = document.createElement("a");

                        botonEditar.textContent = "Editar";
                        botonBorrar.textContent = "Borrar";

                        enlace_edit.setAttribute("class","botonesDone");
                        botonEditar.setAttribute("href","index.php?route=task/edit&id="+id);
                        botonBorrar.setAttribute("href","index.php?route=task/delete&id="+id);
                        botonBorrar.setAttribute("class","botonBorrar");

                        enlace_edit.append(botonEditar,botonBorrar);
                    }

                    div.append(enlace_edit);
                    div_cuerpo.append(parrafoDesc,parrafoNombre);
                    parrafo.append(div_cabecera,div_cuerpo,div);
                    break;
                case "Institucion":
                    parrafo.textContent = texto;

                    enlace_elim.setAttribute("href","index.php?route=inst/delete&id="+id);
                    
                    // Los metemos en el parrafo que hemos creado
                    div.append(enlace_elim);

                    // Añadimos el div con los botones creados al parrafo
                    parrafo.append(div);
                    break;
                default:
                    console.log("No se ha podido encontrar la tabla");
                    break;
            }

            // Y lo añadimos como hijo al buscador donde se encuentran nuestros resultados
            document.getElementById(parrafoResultados).append(parrafo);        
        });

        

        // Creamos una función con una promesa para retrasar el procesamiento y le asignamos la clase visible (esto evitará el parpadeo a la hora de recoger datos con el ajax)
        const sleep = (ms = 0) => new Promise(resolve => setTimeout(resolve, ms));
        await sleep(200);

        if(tabla=="Objeto"){
            document.getElementById(parrafoResultados).setAttribute("class","visible Robjeto");
        }else{
            document.getElementById(parrafoResultados).setAttribute("class","visible");
        }
    })
    .catch((error) => {

        // Si da algún tipo de error lo mostramos por consola
        console.log(error);
    });
}