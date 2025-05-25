@include('layouts.head')

<body>
    @include('layouts.navheader')

    <div class="eventos-main">
        <div style="display: flex; flex-direction: column; width: 100%; align-items: center; gap: 40px;">

            @if ($curso->img != null)
                <div class="clase-banner" style="background-image: linear-gradient(to top, rgba(2, 77, 223, 1), rgba(0, 0, 0, 0) 50%), url('{{ asset('storage/' . $curso->img) }}');"></div>
            @endif

            <div class="evento-nombre">
                <h1>{{ $curso->nombre }}</h1>
                <div>
                    <img src="{{ asset('img/separador.png') }}" alt="Separador">
                </div>
            </div>

            @include('layouts.contenido')

            {{-- PDF --}}
            @if ($curso->pdf != null)
                <div style="display: flex; flex-direction: column; width: 100%; align-items: center; margin-top: 40px;">
                    <div style="width: 100%; display: flex; justify-content: center; align-items: center;">
                        <a class="pdf-download" href="{{ asset('storage/' . $curso->pdf) }}" target="_blank" class="pdf-mobile">
                            <i class="fa-solid fa-file-pdf"></i>
                            <p>Descargar PDF</p>
                        </a>
                    </div>
                    <div class="eventos-main-contenidos">
                        <div id="pdf-viewer-container">
                            <div id="pdf-controls">
                                <div>
                                    <button id="prev-page" class="pdf-button"><i class="fa-solid fa-angle-left"></i></button>
                                    <button id="next-page" class="pdf-button"><i class="fa-solid fa-angle-right"></i></button>
                                </div>
                                
                                <div style="display: flex; align-items: center;">
                                    <span id="page-count">Página <span id="current-page">1</span> de <span id="total-pages">0</span></span>
                                    <div style="display: flex; gap: 5px;">
                                        <input type="number" id="page-num" min="1" value="1" style="width: 50px;"> 
                                        <button id="go-to-page" class="pdf-button"><i class="fa-solid fa-search"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div id="pdf-viewer" class="curso-pdf"></div>
                        </div>           
                    </div>
                </div>
            @endif

            {{-- Publicaciones --}}
            <div style="display: flex; flex-direction: column; width: 100%; align-items: center;">
                <div class="clase-posts-separador">
                    <i class="fa fa-th" aria-hidden="true"></i>
                </div>
                <div style="width: 100%; display: flex; justify-content: center; align-items: center;">
                    <div class="clase-posts">
                        @if (!empty($publicaciones) && $publicaciones->isNotEmpty())
                            @include('layouts.publicacion-grid', ['publicaciones' => $publicaciones])
                        @else
                            <div style="grid-column: 1 / -1; display: flex; justify-content: center; align-items: center; padding: 20px 0px;">
                                <div class="no-publicaciones">
                                    <img src="{{ asset('img/jammo-dead-ic.png') }}" alt="No hay publicaciones">
                                    <p>No hay publicaciones disponibles para este curso.</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
    
    <script>
        function ajustarAlturasAcordeon() {
            document.querySelectorAll('.clase-infos-info.active').forEach(parent => {
                const body = parent.querySelector('.clase-infos-info-body');
                body.style.maxHeight = body.scrollHeight + "px";
            });
        }

        // Acordeón: Toggle activo y altura
        document.querySelectorAll('.clase-infos-info-header').forEach(header => {
            header.addEventListener('click', () => {
                const parent = header.parentElement;
                const body = parent.querySelector('.clase-infos-info-body');
                parent.classList.toggle('active');

                if (parent.classList.contains('active')) {
                    body.style.maxHeight = body.scrollHeight + "px";
                } else {
                    body.style.maxHeight = "0";
                    setTimeout(() => {
                        body.style.maxHeight = null;
                    }, 400);
                }
            });
        });

        // Escuchar resize y ajustar alturas si es necesario
        window.addEventListener('resize', () => {
            ajustarAlturasAcordeon();
        });

        // Llamar también al cargar por si inicia en mobile
        window.addEventListener('DOMContentLoaded', () => {
            ajustarAlturasAcordeon();
        });
    </script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.min.js"></script>
    <script>
        // Configuración de PDF.js
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.worker.min.js';

        let pdfDoc = null,
            pageNum = 1,
            pageRendering = false,
            pageNumPending = null,
            scale = calculateScale();

        function calculateScale() {
            return window.innerWidth < 768 ? Math.min(1.2, window.innerWidth / 600) : 1.5;
        }

        // Función para renderizar la página
        function renderPage(num) {
            pageRendering = true;

            pdfDoc.getPage(num).then(function (page) {
                const canvas = document.createElement('canvas');
                const context = canvas.getContext('2d');
                const viewer = document.getElementById('pdf-viewer');

                viewer.innerHTML = '';
                viewer.appendChild(canvas);

                const containerWidth = viewer.clientWidth - 20;
                const pageWidth = page.getViewport({ scale: 1.0 }).width;
                const dynamicScale = Math.min(containerWidth / pageWidth, calculateScale());

                const viewport = page.getViewport({ scale: dynamicScale });
                canvas.height = viewport.height;
                canvas.width = viewport.width;

                const renderContext = {
                    canvasContext: context,
                    viewport: viewport
                };

                const renderTask = page.render(renderContext);
                renderTask.promise.then(function () {
                    pageRendering = false;
                    if (pageNumPending !== null) {
                        renderPage(pageNumPending);
                        pageNumPending = null;
                    }
                });
            });

            document.getElementById('current-page').textContent = num;
            document.getElementById('page-num').value = num;
        }

        function queueRenderPage(num) {
            if (pageRendering) {
                pageNumPending = num;
            } else {
                renderPage(num);
            }
        }

        // Cargar PDF
        pdfjsLib.getDocument("{{ asset('storage/' . $curso->pdf) }}").promise.then(function (pdf) {
            pdfDoc = pdf;
            document.getElementById('total-pages').textContent = pdf.numPages;
            renderPage(pageNum);

            // Observar tamaño del contenedor
            const resizeObserver = new ResizeObserver(() => {
                if (!pageRendering) {
                    scale = calculateScale();
                    renderPage(pageNum);
                }
            });
            resizeObserver.observe(document.getElementById('pdf-viewer-container'));

            // Observar cambio de tamaño de ventana (por ejemplo, móvil <-> escritorio)
            window.addEventListener('resize', () => {
                if (!pageRendering) {
                    scale = calculateScale();
                    renderPage(pageNum);
                }
            });
        });

        // Controles de navegación
        document.getElementById('prev-page').addEventListener('click', function () {
            if (pageNum <= 1) return;
            pageNum--;
            queueRenderPage(pageNum);
        });

        document.getElementById('next-page').addEventListener('click', function () {
            if (pageNum >= pdfDoc.numPages) return;
            pageNum++;
            queueRenderPage(pageNum);
        });

        document.getElementById('go-to-page').addEventListener('click', function () {
            let num = parseInt(document.getElementById('page-num').value);
            if (isNaN(num)) return;
            if (num < 1) num = 1;
            if (num > pdfDoc.numPages) num = pdfDoc.numPages;
            pageNum = num;
            queueRenderPage(pageNum);
        });

        document.getElementById('page-num').addEventListener('keypress', function (e) {
            if (e.key === 'Enter') {
                document.getElementById('go-to-page').click();
            }
        });
    </script>
    
    @include('layouts.footer')
</body>

    <!--
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Detalles del Curso</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        h1 { color: #333; }
        .campo { margin-bottom: 10px; }
        .label { font-weight: bold; }
    </style>
</head>
<body>

    <h1>Detalles del curso: {{ $curso->nombre }}</h1>

    <div class="campo"><span class="label">Nivel educativo:</span> {{ $curso->nivelEducativo->nombre }}</div>
    <div class="campo"><span class="label">Duración:</span> {{ $curso->duracion ?? 'No especificada' }}</div>
    <div class="campo"><span class="label">Posibilidades de continuidad:</span><br> {{ $curso->posibilidades_continuidad ?? 'No especificadas' }}</div>
    <div class="campo"><span class="label">Sector profesional:</span> {{ $curso->sector_profesional ?? 'No especificado' }}</div>
    <div class="campo"><span class="label">Salidas profesionales:</span><br> {{ $curso->salidas_profesionales ?? 'No especificadas' }}</div>
    <div class="campo"><span class="label">Prácticas en empresas:</span> {{ $curso->practicas_en_empresas ? 'Sí' : 'No' }}</div>

    @if ($curso->asignaturas_pdf)
        <div class="campo">
            <span class="label">Asignaturas principales:</span>
            <a href="{{ asset('storage/' . $curso->asignaturas_pdf) }}" target="_blank">Ver PDF</a>
        </div>
    @endif

    <div class="campo">
        <span class="label">Imágenes:</span><br>
        @forelse($curso->fotos as $foto)
            <img src="{{ asset('storage/' . $foto->ruta_imagen) }}" alt="Imagen del curso" width="150" style="margin: 10px;">
        @empty
            <p>No hay imágenes disponibles.</p>
        @endforelse
    </div>

    <a href="{{ route('niveles.index') }}">← Volver al listado de cursos</a>

</body>
</html>
-->