
<script>


// URL del archivo PHP que mantiene la sesión activa
const mantenerSessionUrl = '<?php echo BASE_URL; ?>/helpers/sessionTimer.php';
// Función para enviar solicitudes de actualización de sesión
function MantenerSession() {
    fetch(mantenerSessionUrl, {
        method: 'POST',
    })
    .then(response => response.json())
    .then(data => {
        console.log(data.status)
        if (data.status === 'error') {
            alert('Tu sesión ha expirado. Serás redirigido al login.');
            window.location.href = '<?php echo BASE_URL ?>/views/auth/login.php'; // Redirige al login
        }
    })
    .catch(error => {
        console.error('Error al mantener la sesión activa:', error);
    });
}



function debounce(func, delay) {
    let timer;
    return function (...args) {
        clearTimeout(timer);
        timer = setTimeout(() => {
            func.apply(this, args);
        }, delay);
    };
}

const debouncedMantenerSession = debounce(MantenerSession, 400);


// Opcional: Mantén la sesión activa con interacciones del usuario
['click', 'mousemove', 'keypress', 'scroll'].forEach(event => {
    window.addEventListener(event, debouncedMantenerSession);
});

</script>