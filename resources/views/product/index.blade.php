<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Product List</title>
</head>
<body>
    <h1>Product List</h1>

    <a href="{{ route('products.create') }}">Create Product</a> ||
    <a href="{{ route('categories.create') }}">Create Category</a> ||
    <a href="{{ route('tags.create') }}">Create Tag</a> ||

    <table border="1" cellpadding="8">
        <thead>
            <tr>
                <th>No.</th>
                <th>Name</th>
                <th>Price</th>
                <th>Category</th>
                <th>Tags</th>
                <th>CreatedBy</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            @foreach($products as $key => $product)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ number_format($product->price, 2) }}</td>
                    <td>{{ $product->category->name ?? "" }}</td>
                    <td>
                        @forelse ($product->tags as $tag)
                            <span style="border:1px solid #ccc; padding:2px 6px; margin-right:4px;">
                                {{ $tag->name }}
                            </span>
                        @empty
                            <em>No Tags</em>
                        @endforelse
                    </td>
                    <td>{{ $product->user->name ?? "" }}</td>
                    <td>
                        @can('update', $product)
                        <a href="{{ route('products.edit', $product) }}">Edit</a>
                        @endcan

                        @can('delete', $product)
                        <form action="{{ route('products.destroy', $product) }}"
                            method="POST"
                            style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    onclick="return confirm('Are you sure?')">
                                Delete
                            </button>
                        </form>
                        @endcan
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
</body>
</html>