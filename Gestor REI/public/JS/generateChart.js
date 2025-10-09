// Sacamos la id del usuario de la URL y cargamos el Script automaticamente
let userId = document.location["href"].split("&")[1].split("=")[1];
window.onload=generateChart(userId);

var timeout = false;
window.addEventListener('resize', function() {
    clearTimeout(timeout);
    timeout = setTimeout(generateChart(userId), 200);
});

function generateChart(userId){

    // Enviamos la petición por get al php para hacer la consulta a BD
    fetch("../app/core/generateChart.php?id="+userId)
    .then((respuesta) => {

        // Comprobamos que hay respuesta de la promesa enviada, de no haberla o dar error soltará este mensaje
        if(!respuesta.ok){ 
            throw new Error("No se ha podido buscar.");
        }

        // Devolvemos la respuesta codificada en JSON
        return respuesta.json();
    })
    .then(resultado => {

        if(resultado.length==0){
            let mensaje = document.createElement("p");
            mensaje.textContent = "No se ha encontrado nada.";
            mensaje.setAttribute("class","mensaje");
            document.getElementById("chart_div").append(mensaje);
        }else{

            // Preestablecemos nuestros contadores
            let completos = 0;
            let pendientes = 0;

            // Revisamos todas las tareas y dependiendo de su estado aumentamos la cantidad de cada uno
            resultado.forEach(dato => {
                if(dato["Estado"]=="Pendiente"){
                    pendientes++;
                }else{
                    completos++;
                }
            });

            // Llamamos a funciones de la API para generar el Chart  
            // Load the Visualization API and the corechart package.
            google.charts.load('current', {'packages':['corechart']});

            // Set a callback to run when the Google Visualization API is loaded.
            google.charts.setOnLoadCallback(drawChart);

            // Callback that creates and populates a data table,
            // instantiates the pie chart, passes in the data and
            // draws it.
            function drawChart() {

                // Create the data table.
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Estado');
                data.addColumn('number', 'Cantidad');
                data.addRows([
                ['Completas', completos],
                ['Incompletas', pendientes]
                ]);

                // Set chart options
                var options = {'title':'Tareas del usuario'};

                // Instantiate and draw our chart, passing in some options.
                var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
                chart.draw(data, options);
            }
        }

    })
    .catch((error) => {

        // Si da algún tipo de error lo mostramos por consola
        console.log(error);
    });
}