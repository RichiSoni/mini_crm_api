@extends('layouts.app')

@section('title', 'Create Category')

@section('content')
<h1>Create Category</h1>

<form method="POST" action="{{ route('categories.store') }}">
    @csrf

    <div>
        <label for="name">Name</label>
        <input id="name" type="text" name="name" value="{{ old('name') }}">
        @error('name')
            <small style="color:red">{{ $message }}</small>
        @enderror
    </div>

    <button type="submit">Add Category</button>
</form>
@endsection