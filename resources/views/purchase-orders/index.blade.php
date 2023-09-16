@extends('layouts.app')

@section('body')
    <div class="container">
        <h1>Purchase Orders</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <a href="{{ route('purchase-orders.create') }}" class="btn btn-primary mb-3">Create New Order</a>

        <table class="table table-hover">
            <thead class="table-primary">
                <tr>
                    <th>#</th>
                    <th>Client Name</th>
                    <th>Request Date</th>
                    <th>Quantity</th>
                    <th>Total Amount</th>
                    <th>Currency</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($purchaseOrders as $purchaseOrder)
                    @php
                        $totalProducts = 0;
                        $totalAmount = 0;
                    @endphp
                    @foreach ($purchaseOrderItems as $purchaseOrderItem)
                        @if ($purchaseOrderItem->purchase_order_id === $purchaseOrder->id)
                            @php
                                $totalProducts += $purchaseOrderItem->quantity;
                                $totalAmount += $purchaseOrderItem->total_amount;
                            @endphp
                        @endif
                    @endforeach
                    <tr>
                        <td class="align-middle">{{ $loop->iteration }}</td>
                        <td class="align-middle">{{ $purchaseOrder->customer->name }}</td>
                        <td class="align-middle">{{ $purchaseOrder->date }}</td>
                        <td class="align-middle">{{ $totalProducts }}</td>
                        <td class="align-middle">{{ $totalAmount }}</td>
                        <td class="align-middle">{{ $purchaseOrderItem->currency_id }}</td>
                        <td class="align-middle">
                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                data-target="#customerModal{{ $purchaseOrder->id }}">View</button>

                            <a href="{{ route('purchase-orders.edit', $purchaseOrder->id) }}"
                                class="btn btn-primary btn-sm">Edit</a>
                            <form action="{{ route('purchase-orders.destroy', $purchaseOrder->id) }}" method="POST"
                                class="d-inline" onsubmit="return confirm('Are you sure you want to delete this order?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <div class="modal fade" id="customerModal{{ $purchaseOrder->id }}" tabindex="-1" role="dialog"
                        aria-labelledby="customerModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="customerModalLabel">Show Orders</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <h5>Client Name: {{ $purchaseOrder->customer->name }}</h5>
                                    <h5>Request Date: {{ $purchaseOrder->date }}</h5>
                                    <h5>Quantity: {{ $totalProducts }}</h5>
                                    <h5>Total Amount: {{ $totalAmount }}</h5>
                                    <h5>Currency: {{ $purchaseOrderItem->currency_id }}</h5>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
    </div>
    @endforeach
    </tbody>
    </table>
    </div>
@endsection
