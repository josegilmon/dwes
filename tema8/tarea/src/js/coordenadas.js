$(document).ready(function () {
    $("#ver-coordenadas").click(getCoordenadas);
});

function getCoordenadas(e) {
    const form = $(e.delegateTarget).closest('form');
    $.ajax({
        type: "POST",
        url: 'index.php',
        data: form.serialize() + "&ver-coordenadas=true",
        context: form,
        dataType: "json",
        success: function (respuesta)
        {
            $(this).find("#lat").val(respuesta.lat);
            $(this).find("#lon").val(respuesta.lon);
            $(this).find("#alt").val(respuesta.alt);
            $(this).find("#nuevo_reparto").prop('disabled', false);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert('Error Message: ' + thrownError);
        }
    });
}