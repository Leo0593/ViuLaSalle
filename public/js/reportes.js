document.addEventListener('DOMContentLoaded', function () {
    const toggleMenus = document.querySelectorAll('.ellipsis-btn');

    toggleMenus.forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.stopPropagation(); // ¡evita que se cierre justo después!

            const menu = this.nextElementSibling;

            // Cerrar todos menos el actual
            document.querySelectorAll('.menu-opciones').forEach(m => {
                if (m !== menu) m.style.display = 'none';
            });

            // Mostrar u ocultar este menú
            menu.style.display = (getComputedStyle(menu).display === 'none') ? 'flex' : 'none';
        });
    });

    // Cierra todos los menús si haces clic fuera
    document.addEventListener('click', function () {
        document.querySelectorAll('.menu-opciones').forEach(menu => {
            menu.style.display = 'none';
        });
    });
});
