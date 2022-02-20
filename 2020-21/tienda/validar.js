function enviarFormulario() {
    var usuario = document.getElementById("usuario").value;
    var password = document.getElementById("password").value;
    
   // Aquí se hace la llamada a la función registrada de PHP
    var respuesta = xajax.request({xjxfun:"validarLogin"}, {mode:'synchronous', parameters: [usuario, password]});
    if (respuesta==false) alert("Nombre de usuario y/o contraseña no válidos.");
    return respuesta;
}

