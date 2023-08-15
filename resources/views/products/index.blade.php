@extends('layouts.app')

@section('body')
    <div class="container">
        <div class="d-flex align-items-center justify-content-between">
            <h1 class="mb-0">List Products</h1>
            <a href="{{ route('products.create') }}" class="btn btn-primary">Add</a>
        </div>
        <hr />
        @if (Session::has('success'))
            <div class="alert alert-success" role="alert">
                {{ Session::get('success') }}
            </div>
        @endif
        <table class="table table-hover">
            <thead class="table-primary">
                <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Barcode</th>
                    <th>Category</th>
                    <th>Description</th>
                    <th>Keywords</th>
                    <th>Active</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if ($products->count() > 0)
                    @foreach ($products as $product)
                        <tr>
                            <td class="align-middle">{{ $loop->iteration }}</td>
                            <td class="align-middle">
                                @if ($product->image)
                                    <img src="{{ asset('/storage/' . $product->image) }}" alt="Product Image"
                                        width="50">
                                @else
                                    No Image
                                @endif
                            </td>
                            <td class="align-middle">{{ $product->name }}</td>
                            <td class="align-middle">{{ $product->barcode }}</td>
                            <td class="align-middle">{{ $product->category->name }}</td>
                            <td class="align-middle">{{ $product->description }}</td>
                            <td class="align-middle">{{ str_replace(' ', '', $product->keywords) }}</td>
                            <td class="align-middle {{ $product->active ? 'text-success' : 'text-danger' }}">
                                {{ $product->active ? 'activated' : 'inactive' }}</td>
                            <td class="align-middle"><span
                                    class="currency-symbol">{{ $product->currency->symbol }}{{ $product->price }}</td>
                            <td class="align-middle">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a href="{{ route('products.edit', $product->id) }}" type="button"
                                        class="btn btn-warning">Edit</a>
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                        type="button" class="btn btn-danger p-0" onsubmit="return confirm('Delete?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger m-0">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td class="text-center" colspan="10">No products found.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
@endsection
