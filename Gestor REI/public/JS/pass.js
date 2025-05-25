
function revisar(){
    if(document.getElementById("contra").value==document.getElementById("contracon").value){
        document.getElementById("guardar").disabled = false;
    }else{
        document.getElementById("guardar").disabled = true;
    }
}