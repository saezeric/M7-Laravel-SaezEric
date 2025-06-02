@extends('layouts.app')

@section('content')
    <h1 class="mb-3">Llistat de pel·lícules</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Títol</th>
                <th>Director</th>
                <th>Any</th>
                <th>Accions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($films as $film)
                <tr>
                    <td>{{ $film->title }}</td>
                    <td>{{ $film->director }}</td>
                    <td>{{ $film->year }}</td>
                    <td>
                        <a href="{{ route('films.edit', $film) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('films.destroy', $film) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
