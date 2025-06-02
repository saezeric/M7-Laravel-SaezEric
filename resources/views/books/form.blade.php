<div class="mb-3">
    <label for="title" class="form-label">Títol</label>
    <input type="text" name="title" class="form-control" value="{{ old('title', $book->title ?? '') }}">
    @error('title')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

<div class="mb-3">
    <label for="author" class="form-label">Autor</label>
    <input type="text" name="author" class="form-control" value="{{ old('author', $book->author ?? '') }}">
    @error('author')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

<div class="mb-3">
    <label for="year" class="form-label">Any</label>
    <input type="number" name="year" class="form-control" value="{{ old('year', $book->year ?? '') }}">
    @error('year')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

<div class="mb-3">
    <label for="description" class="form-label">Descripció</label>
    <textarea name="description" class="form-control">{{ old('description', $book->description ?? '') }}</textarea>
</div>
