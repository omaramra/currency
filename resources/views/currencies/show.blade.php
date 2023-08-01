@extends('layouts.app')

@section('body')
    <div class="container">
        <h1>Currency Details</h1>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $currencies->name }}</h5>
                <p class="card-text"><strong>Symbol:</strong> {{ $currencies->symbol }}</p>
                <p class="card-text"><strong>Decimal Digits:</strong> {{ $currencies->decimal_digits }}</p>
                <p class="card-text"><strong>Virtual:</strong> {{ $currencies->is_virtual ? 'Yes' : 'No' }}</p>
                <p class="card-text"><strong>Status:</strong> {{ $currencies->is_status ? 'activated' : 'inactive' }}</p>


                <a href="{{ route('currencies.edit', $currencies->id) }}" class="btn btn-primary">Edit</a>

                <form action="{{ route('currencies.destroy', $currencies->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger"
                        onclick="return confirm('Are you sure you want to delete this currency?')">Delete</button>
                </form>
            </div>
        </div>
    </div>
@endsection
