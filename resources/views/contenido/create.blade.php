<h1>Contenidos</h1>

{{-- Formulario para crear nuevo contenido --}}
<form action="{{ route('contenido.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <label>ID Vista:</label>
    <input type="number" name="id_vista" required>
    <br>
    
    <label>Vista Tipo:</label>
    <select name="vista_tipo" required>
        <option value="curso">Curso</option>
        <option value="evento">Evento</option>
    </select>
    <br>

    <label for="tipo">Tipo:</label>
    <select name="tipo" id="tipo" required>
        <option value="contenedor" selected>Contenedor</option>
        <option value="columna">Columna</option>
    </select>
    <br>

    <label>Título:</label>
    <input type="text" name="titulo" maxlength="255">
    <br>

    <label>Descripción:</label>
    <textarea name="descripcion"></textarea>
    <br>

    <label>Imagen (archivo):</label>
    <input type="file" name="imagen" accept="image/*">
    <br>


    <label>Video (ruta):</label>
    <input type="text" name="video" maxlength="255">
    <br>

    <label>Opción:</label>
    <input type="number" name="opcion" required>
    <br>

    <button type="submit">Crear Contenido</button>
</form>
