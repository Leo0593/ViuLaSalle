// Inicializar carruseles al cargar la página
document.addEventListener('DOMContentLoaded', function () {
    const carousels = document.querySelectorAll('.carousel-container');
    carousels.forEach(carousel => {
        const slides = carousel.querySelectorAll('.carousel-slide');
        if (slides.length > 0) {
            slides[0].classList.add('active');
        }
    });
});

// Función para mover el carrusel
function moveSlide(button, direction) {
    const carousel = button.parentElement;
    const slides = carousel.querySelectorAll('.carousel-slide');
    let activeIndex = 0;

    // Encontrar el slide activo actual
    slides.forEach((slide, index) => {
        if (slide.classList.contains('active')) {
            slide.classList.remove('active');
            activeIndex = index;
        }
    });

    // Calcular nuevo índice
    let newIndex = activeIndex + direction;
    if (newIndex >= slides.length) {
        newIndex = 0;
    } else if (newIndex < 0) {
        newIndex = slides.length - 1;
    }

    // Mostrar nuevo slide
    slides[newIndex].classList.add('active');
}