@extends('layouts.app')

@section('body')
    <h1 class="mb-0">Edit currency</h1>
    <hr />
    <form action="{{ route('currencies.update', $currencies->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $currencies->name }}" required>
        </div>
        <div class="form-group">
            <label for="symbol">Symbol</label>
            <input type="text" name="symbol" id="symbol" class="form-control" value="{{ $currencies->symbol }}"
                required>
        </div>
        <div class="form-group">
            <label for="decimal_digits">Decimal Digits</label>
            <input type="number" name="decimal_digits" id="decimal_digits" class="form-control"
                value="{{ $currencies->decimal_digits }}" required>
        </div>
        <div class="form-group">
            <label for="is_virtual">Is Virtual?</label>
            <select name="is_virtual" id="is_virtual" class="form-control" required>
                <option value="0" {{ $currencies->is_virtual == 'No' ? 'selected' : '' }}>No</option>
                <option value="1" {{ $currencies->is_virtual == 'Yes' ? 'selected' : '' }}>Yes</option>
            </select>
        </div>
        <div class="form-group">
            <label for="is_status">Status</label>
            <select name="is_status" id="is_status" class="form-control" required>
                <option value="0" {{ $currencies->is_status == 'inactive' ? 'selected' : '' }}>inactive</option>
                <option value="1" {{ $currencies->is_status == 'activated' ? 'selected' : '' }}>activated</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
@endsection
