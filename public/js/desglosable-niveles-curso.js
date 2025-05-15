document.addEventListener('DOMContentLoaded', () => {
    // Selecciona TODOS los toggle-nivel en AMBAS vistas
    const toggles = document.querySelectorAll('.toggle-nivel');
    
    console.log('Total toggles encontrados:', toggles.length); // Debug
    
    toggles.forEach(toggle => {
        toggle.addEventListener('click', function (e) {
            e.preventDefault();
            const nivelId = this.dataset.nivel;
            
            // Busca en AMBAS ubicaciones posibles (móvil y escritorio)
            // Utilizamos querySelectorAll para encontrar todos los contenedores con el mismo ID
            const hijosElements = document.querySelectorAll(`#nivel-${nivelId}`);
            
            console.log(`Contenedores nivel-${nivelId} encontrados:`, hijosElements.length); // Debug
            
            if (hijosElements.length === 0) {
                console.error(`No se encontró el contenedor con id nivel-${nivelId}`);
                return;
            }
            
            // Aplicar el toggle a TODOS los contenedores con ese ID
            hijosElements.forEach(hijos => {
                const isVisible = getComputedStyle(hijos).display !== 'none';
                hijos.style.display = isVisible ? 'none' : 'block';
                
                // Encuentra el icono dentro del toggle que se hizo clic
                const icon = this.querySelector('.toggle-icon');
                if (icon) {
                    icon.classList.toggle('rotated', !isVisible);
                }
            });
        });
    });
});