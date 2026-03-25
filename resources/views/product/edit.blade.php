{{-- @extends('layouts.app')

@section('title', 'Edit Product')

@section('content') --}}
<x-app-layout>
<h1>Edit Product</h1>

<form method="POST" action="{{ route('products.update', $product) }}">
    @csrf
    @method('PUT')

    <div>
        <label for="name">Name</label>
        <input
            id="name"
            type="text"
            name="name"
            value="{{ old('name', $product->name) }}"
        >
        @error('name')
            <small style="color:red">{{ $message }}</small>
        @enderror
    </div>

    <div>
        <label for="price">Price</label>
        <input
            id="price"
            type="number"
            step="0.01"
            name="price"
            value="{{ old('price', $product->price) }}"
        >
        @error('price')
            <small style="color:red">{{ $message }}</small>
        @enderror
    </div>

    <div>
        <label for="category">Category</label>
        <select name="category_id" id="category">
        @foreach ($categories as $category)
            <option value="{{ $category->id }}"
                {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                {{ $category->name }}
            </option>
        @endforeach
    </select>
        @error('category_id')
            <small style="color:red">{{ $message }}</small>
        @enderror
    </div>

    <div>
        <label>Tags</label><br>

        @foreach ($tags as $tag)
            <label>
                <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                    {{ in_array(
                        $tag->id,
                        old('tags', $product->tags->pluck('id')->toArray())
                    ) ? 'checked' : '' }}>
                {{ $tag->name }}
            </label><br>
        @endforeach
    </div>

    <button type="submit">Update</button>
</form>
{{-- @endsection --}}
</x-app-layout>