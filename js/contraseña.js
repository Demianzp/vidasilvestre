function togglePasswordVisibility() {
    const passwordInput = document.getElementById('passwordd');
    const toggleEye = document.getElementById('toggle-eye');

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleEye.innerHTML = '<i class="fas fa-eye-slash"></i>';
    } else {
        passwordInput.type = 'password';
        toggleEye.innerHTML = '<i class="fas fa-eye"></i>';
    }
}
document.getElementById('formulario').addEventListener('submit', function(event) {
    const contrasena = document.getElementById('passwordd').value;
    let error = false;

    if (contrasena.length < 4) {
        document.getElementById('passwordError').innerText = 'La contraseña debe tener al menos 4 caracteres.';
        error = true;
    } else {
        document.getElementById('passwordError').innerText = '';
    }

    if (error) {
        event.preventDefault();
    }
});