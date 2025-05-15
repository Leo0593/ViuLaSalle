document.addEventListener('DOMContentLoaded', () => {
    const toggles = document.querySelectorAll('.toggle-nivel');

    toggles.forEach(toggle => {
        toggle.addEventListener('click', function (e) {
            e.preventDefault();
            const nivelId = this.dataset.nivel;
            const hijos = document.getElementById(`nivel-${nivelId}`);
            const icon = this.querySelector('.toggle-icon');

            console.log('Hijos encontrados:', hijos); // <-- esto ayuda a depurar

            if (!hijos) {
                alert(`No se encontró el contenedor con id nivel-${nivelId}`);
                return;
            }

            const isVisible = getComputedStyle(hijos).display !== 'none';
            hijos.style.display = isVisible ? 'none' : 'block';

            icon.classList.toggle('rotated', !isVisible);
        });
    });
});