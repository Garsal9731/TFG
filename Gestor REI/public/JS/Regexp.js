function Comprobar(texto,expresion) {
    switch (expresion) {
        case "Correo":
            
            // Recogemos el campo que vamos a modificar para mostrar los estilos si la expresión está correcta
            let campo = document.getElementById("Correo");

            // Comprobamos que el hilo tenga más de 
            if(texto.length>0){
                
                // Creamos nuestra expresión regular para los correos
                let regular = new RegExp(/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/);

                // Si la expresión regular concuerda mostramos en verde y si no en rojo
                if(regular.test(texto)){
                    campo.style.outlineColor = "green";
                }else{
                    campo.style.outlineColor = "red";
                }
            }else{

                // Si está vacío le devolvemos el color negro al outline
                campo.style.outlineColor = "black";
            }
            break;
    }
}