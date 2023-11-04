document.getElementById('email').addEventListener('input', function() {
    campo = event.target;
    valido = document.getElementById('emailOK');

    // Expresión regular para validar un correo electrónico con dominio "gmail.com"
    emailRegex = /^[a-zA-Z0-9._%+-]+@gmail\.com$/i;

    if (emailRegex.test(campo.value)) {
        valido.innerText = "Correo válido";
        valido.style.color = "green";
    } else {
        valido.innerText = "Correo incorrecto";
        valido.style.color = "red";
    }
});

document.getElementById('celular').addEventListener('input', function() {
    campo = event.target;
    valido = document.getElementById('celularOK');
    guardarBtn = document.getElementById('guardarBtn'); // Agregamos esta línea

    // Expresión regular para validar números de teléfono móviles argentinos con código de país "+54"
    telefonoRegex = /^\d{10}$/;

    if (telefonoRegex.test(campo.value)) {
        valido.innerText = "Número de teléfono válido";
        valido.style.color = "green";
        guardarBtn.disabled = false; // Habilitamos el botón si el número es válido
    } else {
        valido.innerText = "Número de teléfono incorrecto";
        valido.style.color = "red";
        guardarBtn.disabled = true; // Deshabilitamos el botón si el número es incorrecto
    }

});

document.getElementById('dni').addEventListener('input', function() {
    campo = event.target;
    valido = document.getElementById('dniOK');

    // Expresión regular para validar números de DNI en Argentina (7 u 8 dígitos numéricos)
    dniRegex = /^[0-9]{8}$/;

    if (dniRegex.test(campo.value)) {
        valido.innerText = "Número de DNI válido";
        valido.style.color = "green";
    } else {
        valido.innerText = "Número de DNI incorrecto";
        valido.style.color = "red";
    }
});