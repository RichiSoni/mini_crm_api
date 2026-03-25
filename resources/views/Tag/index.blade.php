@extends('layouts.app')

@section('title', 'Tag List')

@section('content')
<h1>Tag List</h1>

<a href="{{ route('tags.create') }}">Create Tag</a> ||
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
        @foreach($tags as $key => $tag)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $tag->name }}</td>
                <td>
                    <a href="{{ route('tags.edit', $tag) }}">Edit</a>

                    <form action="{{ route('tags.destroy', $tag) }}"
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