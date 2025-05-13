document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById("modalImagen");
    const modalImg = document.getElementById("imgAmpliada");
    const span = document.getElementsByClassName("cerrar-modal")[0];

    document.querySelectorAll('.box-publicacion-img').forEach(div => {
        div.addEventListener('click', function () {
            const imageUrl = this.style.backgroundImage.slice(5, -2);
            modalImg.classList.add('cargando');
            modal.style.display = "block";

            // Forzar reflow para que la animación funcione
            void modal.offsetWidth;
            modal.classList.add('mostrar');

            modalImg.src = imageUrl;

            // Cuando la imagen se carga
            modalImg.onload = function () {
                modalImg.classList.remove('cargando');
            };
        });
    });

    // Cerrar modal
    function cerrarModal() {
        modal.classList.remove('mostrar');
        setTimeout(() => {
            modal.style.display = "none";
        }, 300); // Tiempo igual a la duración de la transición
    }

    span.onclick = cerrarModal;

    modalImg.onclick = function (e) {
        e.stopPropagation(); // Evita que el click se propague al modal
        cerrarModal();
    };

    window.onclick = function (event) {
        if (event.target == modal) {
            cerrarModal();
        }
    };
});

document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById("modalImagen");
    const modalImg = document.getElementById("imgAmpliada");
    const span = document.getElementsByClassName("cerrar-modal")[0];
    const btnDescargar = document.getElementById("btnDescargarImagen"); // <-- puede ser null
    const btnCancelar = document.getElementById("btnCancelar");

    // Cerrar modal
    function cerrarModal() {
        modal.classList.remove('mostrar');
        setTimeout(() => {
            modal.style.display = "none";
        }, 300);
    }

    document.querySelectorAll('.box-publicacion-img').forEach(div => {
        div.addEventListener('click', function () {
            const imageUrl = this.style.backgroundImage.slice(5, -2);
            modalImg.classList.add('cargando');
            modal.style.display = "block";

            modalImg.src = imageUrl;

            // ✅ Solo si el botón existe (usuario autenticado)
            if (btnDescargar) {
                const fileName = obtenerNombreArchivo(imageUrl);
                btnDescargar.href = imageUrl;
                btnDescargar.download = fileName;
            }

            void modal.offsetWidth;
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
});