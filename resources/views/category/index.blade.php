@extends('layouts.app')

@section('title', 'Category List')

@section('content')
<h1>Category List</h1>

<a href="{{ route('categories.create') }}">Create Category</a> ||
<a href="{{ route('products.index') }}">View Products</a>

<table border="1" cellpadding="8">
    <thead>
        <tr>
            <th>No.</th>
            <th>Name</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        @foreach($categories as $key => $category)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $category->name }}</td>
                <td>
                    <a href="{{ route('categories.edit', $category) }}">Edit</a>

                    <form action="{{ route('categories.destroy', $category) }}"
                          method="POST"
                          style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                onclick="return confirm('Are you sure?')">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection