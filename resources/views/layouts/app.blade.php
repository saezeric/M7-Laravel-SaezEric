<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Gestor de llibres</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light text-dark">

    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ route('books.index', [], true) }}">Llibres</a>
            <a class="btn btn-primary" href="{{ route('books.create', [], true) }}">Afegir llibre</a>
        </div>
    </nav>

    <div class="container">
        @yield('content')
    </div>

</body>
</html>
