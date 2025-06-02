<div class="mb-3">
    <label for="title" class="form-label">Títol</label>
    <input type="text" name="title" class="form-control" value="{{ old('title', $film->title ?? '') }}">
    @error('title')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

<div class="mb-3">
    <label for="director" class="form-label">Director</label>
    <input type="text" name="director" class="form-control" value="{{ old('director', $film->director ?? '') }}">
    @error('director')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

<div class="mb-3">
    <label for="year" class="form-label">Any</label>
    <input type="number" name="year" class="form-control" value="{{ old('year', $film->year ?? '') }}">
    @error('year')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

<div class="mb-3">
    <label for="description" class="form-label">Descripció</label>
    <textarea name="description" class="form-control">{{ old('description', $film->description ?? '') }}</textarea>
    @error('description')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>
