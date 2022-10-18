<?php
/** @var \App\Models\Pelicula $pelicula */
/** @var \App\Models\Usuario $usuario */
?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Película Reservada con Éxito</title>
</head>
<body>
    <h1>Película Reservada con Éxito</h1>

    <p>¡Hola, {{ $usuario->email }}!</p>
    <p>Te confirmamos que tu reserva de la película <b>{{ $pelicula->titulo }}</b> fue realizada con éxito.</p>

    <p>
        Saludos cordiales,<br>
        DV Películas.
    </p>
</body>
</html>
