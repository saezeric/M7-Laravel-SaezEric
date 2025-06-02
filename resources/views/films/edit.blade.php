@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edita film</h1>
    <form action="{{ route('films.update', $film) }}" method="POST">
        @csrf
        @method('PUT')
        @include('films.form')
        <button type="submit" class="btn btn-primary">Actualitza</button>
    </form>
</div>
@endsection
