@extends('layouts.app')

@section('body')
    <div class="container">
        <h1>Add Currency</h1>

        <form action="{{ route('currencies.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="symbol">Symbol</label>
                <input type="text" name="symbol" id="symbol" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="decimal_digits">Decimal Digits</label>
                <input type="number" name="decimal_digits" id="decimal_digits" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="is_virtual">Is Virtual?</label>
                <select name="is_virtual" id="is_virtual" class="form-control" required>
                    <option value="0">No</option>
                    <option value="1">Yes</option>
                </select>
            </div>
            <div class="form-group">
                <label for="is_status">Status</label>
                <select name="is_status" id="is_status" class="form-control" required>
                    <option value="0">inactive</option>
                    <option value="1">activated</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Add</button>
        </form>
    </div>
@endsection
