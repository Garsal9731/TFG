// Comprobamos si existe el parrafo con el mensaje de error, si existe lo recogemos
if(document.getElementById("mensajeError")){
    window.onload=recogerError(document.getElementById("mensajeError"));
}
if(document.getElementById("mensajeCorrecto")){
    window.onload=recogerError(document.getElementById("mensajeCorrecto"));
}

async function recogerError(mensaje){
    console.log(mensaje);

    // Recogiendo el mensaje de error creamos un div con el mensaje para mostrarlo por pantalla con CSS
    let div=document.createElement("div");
    div.setAttribute("class",mensaje.id);
    div.textContent = mensaje.textContent;

    // Lo metemos en el cuerpo para verlo
    document.getElementsByTagName("body")[0].append(div);

    // Creamos una función de espera para poder hacer bien las transiciones
    const sleep = (ms = 0) => new Promise(resolve => setTimeout(resolve, ms));
    await sleep(200);

    // Hacemos un toggle con una clase del CSS que cambia la posición para que se vea
    div.classList.toggle("visible");

    // Esperamos 5 segundos para que el usuario pueda leer el mensaje
    await sleep(5000);

    // Volvemos a hacer el toggle para ocultar el mensaje de nuevo
    div.classList.toggle("visible");
}