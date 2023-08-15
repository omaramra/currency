@extends('layouts.app')

@section('body')
    <div class="container">
        <h1>Edit Customer</h1>
        <a href="{{ route('customers.index') }}" class="btn btn-secondary">Back to Customers</a>
        <br><br>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('customers.update', $customer->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name"
                    value="{{ old('name', $customer->name) }}" required>
            </div>

            <div class="form-group">
                <label for="mobile_number">Mobile Number</label>
                <input type="text" class="form-control" id="mobile_number" name="mobile_number"
                    value="{{ old('mobile_number', $customer->mobile_number) }}" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email"
                    value="{{ old('email', $customer->email) }}">
            </div>

            <div class="form-group">
                <label for="phone_number">Phone Number</label>
                <input type="text" class="form-control" id="phone_number" name="phone_number"
                    value="{{ old('phone_number', $customer->phone_number) }}">
            </div>

            <div class="form-group">
                <label for="image">Image</label>
                @if ($customer->image)
                    <div>
                        <img src="{{ asset('/storage/' . $customer->image) }}" alt="Customer Image" class="img-thumbnail"
                            style="max-width: 100px;">
                    </div>
                @else
                    <div>No Image</div>
                @endif
            </div>

            <div class="form-group"> <label for="active">Active</label> <select class="form-control" id="active"
                    name="active">
                    <option value="0" {{ $customer->active == 'Deactivate' ? 'selected' : '' }}>Deactivate</option>
                    <option value="1" {{ !$customer->active == 'activated' ? 'selected' : '' }}>Activate</option>
                </select> </div>

            <br>
            <button type="submit" class="btn btn-primary">Update Customer</button>
        </form>
    </div>
@endsection
