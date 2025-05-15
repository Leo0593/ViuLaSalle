$(document).ready(function () {
    $('.btn-comentarios').click(function () {
        const id = $(this).data('id');
        $('#comentarios-' + id).slideToggle(); // cambia display entre none y block con animación
    });
});
