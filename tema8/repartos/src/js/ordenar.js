$(document).ready(function () {
    $(".ordenar").click(ordenarEnvio);
});

function ordenarEnvio(e) {
    e.preventDefault();
    e.stopImmediatePropagation();
    const id = $(e.target).parent().find('input:hidden:first').val();
    $.ajax({
        type: "POST",
        url: 'index.php',
        data: {
            "lista-reparto-id": id,
            "ordenar-envios": true
        },
        dataType: "json",
        success: function (respuesta)
        {
            ordenados = respuesta.ordenRepartos.map(x => $(`#${respuesta.listaRepartoId}-${x}`));
            $(`#${respuesta.listaRepartoId}`).append(ordenados);
            setTimeout(function () {
                alert("Lista ordenada!");
            }, 0);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert('Error Message: ' + thrownError);
        }
    });
}