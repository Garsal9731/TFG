enlace = document.createElement("a");
flecha = document.createElement("i");
flecha.setAttribute("class","fa-solid fa-arrow-left");

if(document.referrer.split("/")[document.referrer.split("/").length-1]=="index.php"){
    enlace.setAttribute("href",document.referrer+"?route=core/logoff");
}else{
    enlace.setAttribute("href",document.referrer);
}

enlace.append(flecha);
enlace.setAttribute("id","flechaAtras");
document.getElementById("barraLateral").append(enlace);