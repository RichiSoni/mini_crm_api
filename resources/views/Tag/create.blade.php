@extends('layouts.app')

@section('title', 'Create Tag')

@section('content')
<h1>Create Tag</h1>

<form method="POST" action="{{ route('tags.store') }}">
    @csrf

    <div>
        <label for="name">Name</label>
        <input id="name" type="text" name="name" value="{{ old('name') }}">
        @error('name')
            <small style="color:red">{{ $message }}</small>
        @enderror
    </div>

    <button type="submit">Add Tag</button>
</form>
@endsection