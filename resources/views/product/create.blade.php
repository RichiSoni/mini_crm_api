<x-app-layout>
<h1>Create Product</h1>

<form method="POST" action="{{ route('products.store') }}">
    @csrf

    <div>
        <label for="name">Name</label>
        <input id="name" type="text" name="name" value="{{ old('name') }}">
        @error('name')
            <small style="color:red">{{ $message }}</small>
        @enderror
    </div>

    <div>
        <label for="price">Price</label>
        <input id="price" type="number" step="0.01" name="price" value="{{ old('price') }}">
        @error('price')
            <small style="color:red">{{ $message }}</small>
        @enderror
    </div>

    <div>
        <label for="category">Category</label>
        <select name="category_id">
            @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
        @error('price')
            <small style="color:red">{{ $message }}</small>
        @enderror
    </div>

    <div>
        <label for="tags">Tags</label>
        @foreach ($tags as $tag)
            <label>
                <input type="checkbox" name="tags[]" value="{{ $tag->id }}">
                {{ $tag->name }}
            </label>
        @endforeach

        @error('tags')
            <small style="color:red">{{ $message }}</small>
        @enderror
    </div>

    <button type="submit">Add</button>
</form>
</x-app-layout>