
// Variables
const passwordInput = document.getElementById('password');
const passwordError = document.getElementById('password-error');
const submitButton = document.getElementById('submit-button');

// Validar contraseña en tiempo real
passwordInput.addEventListener('input', function () {
    const password = passwordInput.value;

    if (password.length < 8) {
        passwordError.textContent = 'La contraseña debe tener al menos 8 caracteres.';
        submitButton.disabled = true; // Deshabilitar el botón de envío
    } else {
        passwordError.textContent = ''; // Limpiar el mensaje 
        submitButton.disabled = false; // Habilitar el botón de envío de neuvo
    }
});
