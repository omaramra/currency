@extends('layouts.app')

@section('body')
    <div class="container">
        <h1>List Customers</h1>

        <a href="{{ route('customers.create') }}" class="btn btn-primary">Add New Customer</a>
        <br><br>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-hover">
            <thead class="table table-primary">
                <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Mobile Number</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if ($customers->count() > 0)
                    @foreach ($customers as $customer)
                        <tr>
                            <td class="align-middle">{{ $loop->iteration }}</td>
                            <td class="align-middle">
                                @if ($customer->image)
                                    <img src="{{ asset('/storage/' . $customer->image) }}" alt="Customer Image"
                                        width="50">
                                @else
                                    No Image
                                @endif
                            </td>
                            <td class="align-middle">{{ $customer->name }}</td>
                            <td class="align-middle">{{ $customer->mobile_number }}</td>
                            <td class="align-middle">{{ $customer->email }}</td>
                            <td class="align-middle">{{ $customer->phone_number }}</td>
                            <td class="align-middle">
                                <form action="{{ route('customers.toggleStatus', $customer->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit"
                                        class="btn {{ $customer->active ? 'btn-success' : 'btn-danger' }} btn-sm">
                                        {{ $customer->active ? 'Activated' : 'Inactive' }}
                                    </button>
                                </form>
                            </td>
                            <td class="align-middle">
                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                    data-target="#customerModal{{ $customer->id }}">View</button>

                                <a href="{{ route('customers.edit', $customer->id) }}"
                                    class="btn btn-primary btn-sm">Edit</a>
                                <form action="{{ route('customers.destroy', $customer->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure you want to delete this customer?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        <div class="modal fade" id="customerModal{{ $customer->id }}" tabindex="-1" role="dialog"
                            aria-labelledby="customerModalLabel{{ $customer->id }}" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="customerModalLabel{{ $customer->id }}">
                                            Show Customers</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <div class="modal-body">
                                        @if ($customer->image)
                                            <img src="{{ asset('/storage/' . $customer->image) }}" alt="Customer Image"
                                                class="img-thumbnail" style="width: 18rem;">
                                        @else
                                            <p>No Image</p>
                                        @endif
                                        <h4 class="modal-title">{{ $customer->name }}</h4>

                                        <h6>Mobile: {{ $customer->mobile_number }}</h6>
                                        <h6>Email: {{ $customer->email }}</h6>
                                        <h6>Phone Number: {{ $customer->phone_number }}</h6>
                                        <h6>
                                            Status: <span class="{{ $customer->active ? 'text-success' : 'text-danger' }}">
                                                {{ $customer->active ? 'Activated' : 'Inactive' }}
                                            </span>
                                        </h6>
                                    </div>
                                    <div class="modal-footer">
                                        <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-primary">Edit
                                            Customer</a>
                                        <form action="{{ route('customers.destroy', $customer->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger"
                                                onclick="return confirm('Are you sure you want to delete this customer?')">Delete
                                                Customer</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
@endsection
