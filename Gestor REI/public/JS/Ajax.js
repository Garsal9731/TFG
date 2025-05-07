function buscarProducto(hilo) {
    alert(hilo);
    if(hilo.length == 0){ 
        document.getElementById("resultados_busqueda").innerHTML = "";
        return;
    }else{
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if(this.readyState == 4 && this.status == 200){
                document.getElementById("resultados_busqueda").innerHTML = this.responseText;
            }
        }
        xmlhttp.open("GET", "../Controller/ajaxProductos.php?peticion="+hilo, true);
        xmlhttp.send();
    }
}