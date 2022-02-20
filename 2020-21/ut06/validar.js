function enviarFormulario() {
    // Se cambia el botón de Enviar y se deshabilita
    //  hasta que llegue la respuesta
    xajax.$('enviar').disabled=true;
    xajax.$('enviar').value="Un momento...";
    
    // Aquí se hace la llamada a la función registrada de PHP
    xajax_validarFormulario (xajax.getFormValues("datos"));
    
    return false;
}

