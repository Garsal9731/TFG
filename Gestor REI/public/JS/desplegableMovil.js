$('.contenedor_icono_burger').on('click', function() {
    $(this).toggleClass('icono_cruz icono_barras');
    $(".barraLateral").toggleClass('visible');
});