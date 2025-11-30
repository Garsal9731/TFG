let cookies_documento = document.cookie;
if(cookies_documento==undefined){
    cookies_documento="";
}
if(!cookies_documento.includes("cookies")){
    aviso = document.createElement("div");
    aviso.setAttribute("class","avisoCookies");
    aviso.setAttribute("id","avisoCookies");

    parrafo = document.createElement("p");
    parrafo.textContent = "Este programa utiliza cookies para almacenar datos, por favor acepte las cookies.";
    parrafo.setAttribute("class","parrafoCookies");

    botones = document.createElement("div");
    botones.setAttribute("class","botonesCookies");

    botonAceptar = document.createElement("div");
    botonAceptar.setAttribute("class","botonAceptar");
    botonAceptar.textContent = "Aceptar";
    botonAceptar.addEventListener("click", (event) => {
        crearCookie();
    });

    botonEsenciales = document.createElement("div");
    botonEsenciales.setAttribute("class","botonEsenciales");
    botonEsenciales.textContent = "Solo Esenciales";
    botonEsenciales.addEventListener("click", (event) => {
        crearCookie();
    });

    botones.append(botonAceptar,botonEsenciales);
    aviso.append(parrafo,botones);

    document.getElementById("login").append(aviso);
}

async function crearCookie(){
    document.cookie = `cookies=ok; expires=${new Date(new Date().getTime()+1000*60*60*24*365).toGMTString()}; path=/`;
    document.getElementById("avisoCookies").setAttribute("class","invisible");

    const sleep = (ms = 0) => new Promise(resolve => setTimeout(resolve, ms));
    await sleep(400);
    document.getElementById("avisoCookies").remove();
}