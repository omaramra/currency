@extends('layouts.app')

@section('body')
    <div class="container">
        <h1>Edit Category</h1>

        <form action="{{ route('categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ $category->name }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Update Category</button>
            <a href="{{ route('categories.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
