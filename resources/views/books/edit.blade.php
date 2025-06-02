@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edita llibre</h1>
    <form action="{{ route('books.update', $book, true) }}" method="POST">
        @csrf
        @method('PUT')
        @include('books.form')
        <button type="submit" class="btn btn-primary">Actualitza</button>
    </form>
</div>
@endsection
