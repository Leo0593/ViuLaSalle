document.addEventListener("DOMContentLoaded", function () {
    const publicaciones = document.querySelectorAll('.box-publicacion');

    publicaciones.forEach(publicacion => {
        // Buscamos el contenedor correcto (media o imagen)
        const container = publicacion.querySelector('.box-publicacion-media-container-media') ||
                          publicacion.querySelector('.box-publicacion-img-container');

        const dots = publicacion.querySelectorAll('.dot');

        if (!container || dots.length === 0) return;

        function updateDots() {
            const scrollPosition = container.scrollLeft;
            const containerWidth = container.offsetWidth;
            const activeIndex = Math.round(scrollPosition / containerWidth);

            dots.forEach((dot, index) => {
                dot.classList.toggle('active', index === activeIndex);
            });
        }

        container.addEventListener('scroll', updateDots);
        updateDots();
    });
});
