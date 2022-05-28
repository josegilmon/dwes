function votar(idProducto, votos) {

    var valoracion = $('#valorar-' + idProducto).val();

    $.ajax({
        type: 'POST',
        url: 'votar.php',
        data: {
            idPr: idProducto,
            cantidad: valoracion
        },
        success: function(response) {
            console.log(response);
            if (response.result) {
                var rating = $('#rating-' + idProducto);
                rating.html(pintarEstrellas(+votos+1, response.result));
            } else {
                alert('Ya has votado por este producto.');
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert('Error Message: ' + thrownError);
        }
    });
}

function pintarEstrellas(votos, valoracion) {
    var html = 'Sin valorar';
    if (votos && valoracion) {
        html = votos + (votos > 1 ? ' Valoraciones ' : ' Valoración ');
        while (valoracion > 0) {
            var icon = valoracion < 1 ? 'fa-star-half': 'fa-star';
            html += '<i class="fas ' + icon + '"></i>';
            valoracion-=1;
        }
    }
    return html;
}