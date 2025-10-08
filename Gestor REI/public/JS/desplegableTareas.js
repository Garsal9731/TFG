function cambiarClase(clase) {
    let icono = document.getElementById(clase);
    icono.classList.toggle("rotado");

    let cuerpo = document.getElementById("cuerpo_"+clase);

    cuerpo.classList.toggle("visible");
    if (cuerpo.classList.contains("visible")) {
        cuerpo.style.height = "0%";
        cuerpo.style.height = "100%";
    } else {
        cuerpo.style.height = "100%";
        cuerpo.style.height = "0%";
    }
    
}