// Por defecto en carga de la pagina lanzará una busqueda para recoger todos los resultados y mostrarlos, esto es necesario ya que quiero que por defecto se muestren todos los resultados al cargar la página (NO HAY OTRA MANERA DE HACERLO)
let clase = document.location["href"].split("=")[1].split("/")[0]
switch (clase) {
    case "user":
        window.onload=buscarAjax('','Usuario');
        break;
    case "item":
        window.onload=buscarAjax('','Objeto');
        break;
    case "task":
        window.onload=buscarAjax('','TareaP');
        window.onload=buscarAjax('','TareaC');
        break;
}

// Tareas al ser 2 campos diferentes usan distintas IDs y para evitar problemas con las otras paginas hay un por defecto, esto ayuda a visualizar los resultados del ajax
function sacarParrafoResultados(letra){
    if(document.getElementById("resultados_busqueda")){     
        var parrafoResultados = "resultados_busqueda";
        
    }else{
        if(letra=="P"){
            var parrafoResultados = "resultados_busqueda_P";
        }
        if(letra=="C"){
            var parrafoResultados = "resultados_busqueda_C";
        }
    }
    return parrafoResultados
}

function buscarAjax(hilo,tabla){
    
    // Sacamos la letra del parrafo que vamos a usar para mostrar los resultados (Si son la pagina de Tareas), si no lo es lo dejamos nulo para poder sacar la respuesta por defecto
    if(tabla=="TareaP" || tabla=="TareaC"){
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

    // Si el hilo está vacio o es 0 mostramos vacío el elemento en el que vamos a colocar los datos y no buscamos 
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
        if(tabla=="TareaP" || tabla=="TareaC"){
            tabla = "Tarea";
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
                    
                    // Si la clave es igual a la ultima clave no añade espacio, en cualquier otro caso si añadirá espacio
                    if (clave==claves.length-1) {
                        texto = texto.concat(dato[clave]);
                    } else {
                        texto = texto.concat(dato[clave]+" ");
                    }
                    
                }
            });
            // Creamos el parrafo con el resultado creado
            let parrafo = document.createElement("p");
            parrafo.textContent = texto;
            parrafo.className = "resultado";

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

                    enlace_edit.textContent = "Editar";

                    // Creamos los enlaces de editar y borrar el usuario, les damos el enlace y un texto
                    enlace_edit.setAttribute("href","index.php?route=user/edit&id="+id);
                    enlace_elim.setAttribute("href","index.php?route=user/delete&id="+id);
                    
                    // Los metemos en el parrafo que hemos creado
                    div.append(enlace_edit,enlace_elim);
                    break;
            
                case "Objeto":
        
                    enlace_edit.textContent = "Editar";

                    // Creamos los enlaces de editar y borrar el usuario, les damos el enlace y un texto
                    enlace_edit.setAttribute("href","index.php?route=item/edit&id="+id);
                    enlace_elim.setAttribute("href","index.php?route=item/delete&id="+id);
                    
                    // Los metemos en el parrafo que hemos creado
                    div.append(enlace_edit,enlace_elim);
                    break;
                case "Tarea":
                    // ! AÑADIR CAMPOS CUSTOMIZADOS PARA LAS TAREAS
                    console.log("tarea");
            
                    enlace_edit.textContent = "Revisar";
                
                    // ! AÑADIR VISTA PARA VER DETALLES DE LAS TAREAS (task details/review), OBJETOS Y AÑADIR ACCESO EDITAR EL USUARIO(SOLO PARA EL ADMIN Y EL PROPIO USUARIO)
                    enlace_edit.setAttribute("href","index.php?route=task/edit&id="+id);
                    div.append(enlace_edit);
                    break;
                default:
                    console.log("No se ha podido encontrar la tabla");
                    break;
            }

            // Añadimos el div con los botones creados al parrafo
            parrafo.append(div);

            // Y lo añadimos como hijo al elemento donde se encuentran nuestros resultados
            document.getElementById(parrafoResultados).append(parrafo);        
        });

        // Creamos una función con una promesa para retrasar el procesamiento y le asignamos la clase visible (esto evitará el parpadeo a la hora de recoger datos con el ajax)
        const sleep = (ms = 0) => new Promise(resolve => setTimeout(resolve, ms));
        await sleep(200);
        document.getElementById(parrafoResultados).setAttribute("class","visible");
    })
    .catch((error) => {

        // Si da algún tipo de error lo mostramos por consola
        console.log(error);
    });
}