@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Nou llibre</h1>
    <form action="{{ route('books.store', [], true) }}" method="POST">
        @csrf
        @include('books.form')
        <button type="submit" class="btn btn-success">Desa</button>
    </form>
</div>
@endsection
