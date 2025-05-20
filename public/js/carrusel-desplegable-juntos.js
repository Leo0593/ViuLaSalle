// Inicializar carruseles al cargar la página
function inicializarCarruseles() {
    const carousels = document.querySelectorAll('.carousel-container');
    carousels.forEach(carousel => {
        const slides = carousel.querySelectorAll('.carousel-slide');
        if (slides.length > 0) {
            slides[0].classList.add('active');
        }
    });
}


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

function inicializarModalImagen() {
    const modal = document.getElementById("modalImagen");
    const modalImg = document.getElementById("imgAmpliada");
    const span = document.getElementsByClassName("cerrar-modal")[0];
    const btnDescargar = document.getElementById("btnDescargarImagen");
    const btnCancelar = document.getElementById("btnCancelar");

    function cerrarModal() {
        modal.classList.remove('mostrar');
        setTimeout(() => {
            modal.style.display = "none";
        }, 300);
    }

    if (!modal || !modalImg) return; // Evita errores si no existen en el DOM

    document.querySelectorAll('.box-publicacion-img').forEach(div => {
        div.addEventListener('click', function () {
            const imageUrl = this.style.backgroundImage.slice(5, -2);
            modalImg.classList.add('cargando');
            modal.style.display = "block";

            modalImg.src = imageUrl;

            if (btnDescargar) {
                const fileName = obtenerNombreArchivo(imageUrl);
                btnDescargar.href = imageUrl;
                btnDescargar.download = fileName;
            }

            void modal.offsetWidth; // reflow para animación
            modal.classList.add('mostrar');

            modalImg.onload = function () {
                modalImg.classList.remove('cargando');
            };
        });
    });

    if (btnCancelar) {
        btnCancelar.addEventListener('click', cerrarModal);
    }

    if (span) {
        span.onclick = cerrarModal;
    }

    if (modalImg) {
        modalImg.onclick = function (e) {
            e.stopPropagation();
            cerrarModal();
        };
    }

    window.onclick = function (event) {
        if (event.target === modal) {
            cerrarModal();
        }
    };

    function obtenerNombreArchivo(url) {
        try {
            const urlObj = new URL(url);
            const pathname = urlObj.pathname;
            const filename = pathname.split('/').pop() || 'imagen_descargada';
            return filename.includes('.') ? filename : `${filename}.jpg`;
        } catch {
            return 'imagen_descargada.jpg';
        }
    }
}