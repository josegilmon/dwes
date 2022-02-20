function enviarCoordenadas() {
    // Se cambia el botón de Enviar y se deshabilita
    //  hasta que llegue la respuesta
    xajax.$('enviarcoordenadas').disabled=true;
    xajax.$('enviardireccion').disabled=true;
    xajax.$('enviarcoordenadas').value="Un momento...";
    
    // Aquí se hace la llamada a la función registrada de PHP
    xajax_ubicaryahoo (xajax.getFormValues("datos"));
    
    return false;
}

function enviarDireccion() {
    // Se cambia el botón de Enviar y se deshabilita
    //  hasta que llegue la respuesta
    xajax.$('enviarcoordenadas').disabled=true;
    xajax.$('enviardireccion').disabled=true;
    xajax.$('enviardireccion').value="Un momento...";
    
    // Aquí se hace la llamada a la función registrada de PHP
    xajax_ubicargoogle (xajax.getFormValues("datos"));
    
    return false;
}

