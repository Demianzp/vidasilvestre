function validarCampos() {
    const formulario = document.getElementById("materiaForm");
    const inputs = formulario.querySelectorAll("input, select");
    let camposIncompletos = false;

    inputs.forEach((input) => {
        if (input.required && input.value.trim() === "") {
            camposIncompletos = true;
        }
    });

    if (camposIncompletos) {
        alert("Por favor, complete todos los campos obligatorios.");
    } else {
        mostrarDatos();
    }
}

function mostrarDatos() {
    const formulario = document.getElementById("materiaForm");
    const datosIngresados = document.getElementById("datosIngresados");

    formulario.style.display = "none";
    datosIngresados.style.display = "block";

    const tbody = datosIngresados.querySelector("tbody");
    tbody.innerHTML = "";

    const formElements = Array.from(formulario.elements);
    formElements.forEach((element) => {
        if (element.type !== "button") {
            const campo = element.getAttribute("data-name");
            const valor = element.value;
            if (campo && valor) {
                const tr = document.createElement("tr");
                const tdCampo = document.createElement("td");
                const tdValor = document.createElement("td");
                tdCampo.textContent = campo;
                tdValor.textContent = valor;
                tr.appendChild(tdCampo);
                tr.appendChild(tdValor);
                tbody.appendChild(tr);
            }
        }
    });
}

function registrarMateria() {
    const formulario = document.getElementById("materiaForm");
    formulario.submit(); // Envía el formulario a "procesar_materia.php"
}