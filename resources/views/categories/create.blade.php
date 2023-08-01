@extends('layouts.app')

@section('body')
    <div class="container">
        <h1>Add Category</h1>

        <form action="{{ route('categories.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Add Category</button>
            <a href="{{ route('categories.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
