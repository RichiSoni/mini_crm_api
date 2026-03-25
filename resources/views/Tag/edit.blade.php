@extends('layouts.app')

@section('title', 'Edit Tag')

@section('content')
<h1>Edit Tag</h1>

<form method="POST" action="{{ route('tags.update', $tag) }}">
    @csrf
    @method('PUT')

    <div>
        <label for="name">Name</label>
        <input
            id="name"
            type="text"
            name="name"
            value="{{ old('name', $tag->name) }}"
        >
        @error('name')
            <small style="color:red">{{ $message }}</small>
        @enderror
    </div>

    <button type="submit">Update</button>
</form>
@endsection