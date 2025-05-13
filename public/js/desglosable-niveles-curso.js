document.addEventListener('DOMContentLoaded', () => {
    const toggles = document.querySelectorAll('.toggle-nivel');

    toggles.forEach(toggle => {
        toggle.addEventListener('click', function (e) {
            e.preventDefault();
            const nivelId = this.dataset.nivel;
            const hijos = document.getElementById(`nivel-${nivelId}`);
            const icon = this.querySelector('.toggle-icon');

            if (hijos.style.display === 'none') {
                hijos.style.display = 'block';
                icon.textContent = '▼';
            } else {
                hijos.style.display = 'none';
                icon.textContent = '▶';
            }
        });
    });
});