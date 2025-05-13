// Por defecto en carga de la pagina lanzará una busqueda para recoger todos los resultados y mostrarlos, esto es necesario ya que quiero que por defecto se muestren todos los resultados al cargar la página (NO HAY OTRA MANERA DE HACERLO)
let clase = document.location["href"].split("=")[1].split("/")[0]
switch (clase) {
    case "user":
        window.onload=buscarAjax('','Usuario');
        break;
}

function buscarAjax(hilo,tabla) {

    // Comprobamos si los resultados están visibles y si lo están los ponemos invisibles
    if (document.getElementById("resultados_busqueda").className=="visible") {
        document.getElementById("resultados_busqueda").setAttribute("class","invisible");
    }

    // Si el hilo está vacio o es 0 mostramos vacío el elemento en el que vamos a colocar los datos y no buscamos 
    if(hilo.length == 0 || hilo==null){ 
        hilo = "%";
    }

    // Comprobamos si hay resultados para borrarlos y renovarlos
    if (document.getElementsByClassName("resultado")){

        // Comprobamos que en los resultados hay un primer hijo, de haberlo borramos el ultimos hijo (esto borrará todos los hijos, ya que el primero acabará siendo el ultimo)
        while (document.getElementById("resultados_busqueda").firstChild) {
            document.getElementById("resultados_busqueda").removeChild(document.getElementById("resultados_busqueda").lastChild);
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
        resultado.forEach(dato => {

            // Sacamos los indices del array resultante de la consulta y preestablecemos variables
            let claves = Object.keys(dato);
            let texto = "";
            let id = 0;
            let enlace_edit = "";
            let enlace_elim = "";

            // Recogemos los datos usando sus claves para poder juntarlos en un solo texto
            claves.forEach(clave => {
                if(clave.includes("Id")){
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

            // Dependiendo de la tabla cambiamos algunos elementos
            switch (tabla) {
                case "Usuario":

                    // Creamos un div donde meter los enlaces
                    let div = document.createElement("div");
                    div.setAttribute("class","divBotones");

                    // Creamos los enlaces de editar y borrar el usuario, les damos el enlace y un texto
                    enlace_edit = document.createElement("a");
                    enlace_edit.setAttribute("href","index.php?route=user/edit&id="+id);
                    enlace_edit.textContent = "Editar";
                    enlace_elim = document.createElement("a");
                    enlace_elim.setAttribute("href","index.php?route=user/delete&id="+id);
                    enlace_elim.textContent = "Eliminar";
                    enlace_elim.setAttribute("class","eliminar");
                    
                    // Los metemos en el parrafo que hemos creado
                    div.append(enlace_edit,enlace_elim);
                    parrafo.append(div);
                    break;
            
                default:
                    console.log("No se ha podido encontrar la tabla");
                    break;
            }

            // Y lo añadimos como hijo al elemento donde se encuentran nuestros resultados
            document.getElementById("resultados_busqueda").append(parrafo);
        });

        // Creamos una función con una promesa para retrasar el procesamiento y le asignamos la clase visible (esto evitará el parpadeo a la hora de recoger datos con el ajax)
        const sleep = (ms = 0) => new Promise(resolve => setTimeout(resolve, ms));
        await sleep(200);
        document.getElementById("resultados_busqueda").setAttribute("class","visible");
    })
    .catch((error) => {
        // Si da algún tipo de error lo mostramos por consola
        console.log(error);
    });
}