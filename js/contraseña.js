
function togglePasswordVisibility() {
    const passwordInput = document.querySelector("#password");
    const toggleEye = document.querySelector("#toggle-eye");

    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        toggleEye.innerHTML = '<i class="fas fa-eye-slash"></i>';
    } else {
        passwordInput.type = "password";
        toggleEye.innerHTML = '<i class="fas fa-eye"></i>';
    }
}
