function validarFormulario() {
    if (validarTelefono() && validarOtrasCampos()) {
        // Envía el formulario si todas las validaciones pasan
        document.getElementById("formulario").submit();
    } else {
        alert("Por favor, complete todos los campos correctamente.");
    }
}

function validarTelefono() {
    const telefonoInput = document.getElementById("telefono");
    const telefono = telefonoInput.value;
    
    // Expresión regular para validar números de teléfono argentinos
    const regexTelefono = /^\+?54[-.\s]?\d{2,4}[-.\s]?\d{6,8}$/;

    if (!regexTelefono.test(telefono)) {
        alert("Por favor, ingrese un número de teléfono válido en formato argentino.");
        telefonoInput.value = ""; // Limpia el campo de entrada
        return false;
    }
    return true;
}

// Función para validar el formato del email
function validarEmail(email) {
    const regexEmail = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
    return regexEmail.test(email);
}

// Función para validar el DNI argentino
function validarDNI(dni) {
    const regexDNI = /^(\d{7,8})$/;

    if (!regexDNI.test(dni)) {
        return false; // No cumple con la longitud requerida
    }

    const dniSinDV = dni.substring(0, dni.length - 1);
    const dvIngresado = dni.substring(dni.length - 1);
    const dniNumerico = parseInt(dniSinDV, 10);

    // Algoritmo de validación del DNI
    const resto = dniNumerico % 23;
    const caracteresValidos = "TRWAGMYFPDXBNJZSQVHLCKE";

    return dvIngresado.toUpperCase() === caracteresValidos.charAt(resto);
}

// Función para validar todo el formulario
function validarFormulario() {
    const emailInput = document.getElementById("email");
    const dniInput = document.getElementById("dni");

    const email = emailInput.value;
    const dni = dniInput.value;

    if (!validarEmail(email)) {
        alert("Por favor, ingrese un email válido.");
        emailInput.value = "";
        return;
    }

    if (!validarDNI(dni)) {
        alert("Por favor, ingrese un DNI argentino válido.");
        dniInput.value = "";
        return;
    }

    // Si todas las validaciones pasan, puedes enviar el formulario
    document.getElementById("formulario").submit();
}

