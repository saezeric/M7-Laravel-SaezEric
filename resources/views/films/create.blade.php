@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Nou film</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('films.store', [], true) }}" method="POST">
        @csrf
        @include('films.form')
        <button type="submit" class="btn btn-success">Desa</button>
    </form>
</div>
@endsection
