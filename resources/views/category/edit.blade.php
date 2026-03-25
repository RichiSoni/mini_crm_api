@extends('layouts.app')

@section('title', 'Edit Category')

@section('content')
<h1>Edit Category</h1>

<form method="POST" action="{{ route('categories.update', $category) }}">
    @csrf
    @method('PUT')

    <div>
        <label for="name">Name</label>
        <input
            id="name"
            type="text"
            name="name"
            value="{{ old('name', $category->name) }}"
        >
        @error('name')
            <small style="color:red">{{ $message }}</small>
        @enderror
    </div>

    <button type="submit">Update</button>
</form>
@endsection