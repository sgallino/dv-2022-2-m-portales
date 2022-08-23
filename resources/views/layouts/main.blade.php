<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') :: DV Películas</title>
    <link rel="stylesheet" href="{{ url('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ url('css/app.css') }}">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-lg bg-light">
            <div class="container-fluid">
                <?php   // La función url() crea una URL absoluta a la carpeta "public" del proyecto, de
                        // manera dinámica. ?>
                <a class="navbar-brand" href="{{ url('/') }}">DV Películas</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Mostrar/Ocultar Navegación">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/') }}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('quienes-somos') }}">Quiénes somos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('admin/peliculas') }}">Administrar Películas</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <main class="container py-3">
            {{-- La directiva @yield define un espacio que este archivo va a "ceder" a cualquier otra vista
                que "extienda" o "herede" de este template.--}}
            @yield('main')
        </main>
        <footer class="footer">
            <p>Da Vinci &copy; 2022</p>
        </footer>
    </div>
</body>
</html>

