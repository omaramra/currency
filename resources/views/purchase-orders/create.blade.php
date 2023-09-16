@extends('layouts.app')

@section('body')
    <div class="container">
        <h1>Create New Purchase Order</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('purchase-orders.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="customer_id">Customer Name</label>
                <select class="form-control" id="customer_id" name="customer_id">
                    @foreach ($customers as $customer)
                        <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                            {{ $customer->name }}
                        </option>
                    @endforeach
                </select>
            </div>


            <div class="form-group">
                <label for="date">Date</label>
                <input type="date" class="form-control" id="date" name="date"
                    value="{{ old('date', date('Y-m-d')) }}">
            </div>

            <h3>Add Products</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Currency</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="productRows">
                    <tr>
                        <td>
                            <select class="form-control product-select" name="product_id[]" onchange="updateProduct(this)">
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}" data-price="{{ $product->price }}"
                                        data-currency="{{ $product->currency->id }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="number" class="form-control price" name="price[]" step="0.01" readonly>
                        </td>
                        <td>
                            <input type="text" class="form-control currency" name="currency_id[]" readonly>
                        </td>
                        <td>
                            <input type="number" class="form-control quantity" name="quantity[]" min="1"
                                value="1" onchange="updateTotal(this)">
                        </td>
                        <td>
                            <input type="text" class="form-control total" name="total_amount[]" readonly>
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm"
                                onclick="removeProduct(this)">Remove</button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <button type="button" class="btn btn-primary" onclick="addProductRow()">Add Product</button>

            <button type="submit" class="btn btn-success mt-3">Create Order</button>
        </form>
    </div>

    <script>
        function updateProduct(select) {
            var selectedOption = select.options[select.selectedIndex];
            var priceInput = select.closest('tr').querySelector('.price');
            var currencyInput = select.closest('tr').querySelector('.currency');



            if (selectedOption) {
                priceInput.value = selectedOption.getAttribute('data-price');
                currencyInput.value = selectedOption.getAttribute('data-currency');



                updateTotal(select);
            }
        }

        function updateTotal(input) {
            var quantity = parseFloat(input.value);

            var row = input.closest('tr');
            var priceInput = row.querySelector('.price');
            var totalInput = row.querySelector('.total');

            if (!isNaN(quantity) && priceInput) {
                var price = parseFloat(priceInput.value);
                var total = (isNaN(price) ? 0 : price) * quantity;

                totalInput.value = total.toFixed(2);
            }
        }




        function addProductRow() {
            var newRow = document.createElement('tr');
            newRow.innerHTML = `
            <td>
                 <select class="form-control product-select" name="product_id[]" onchange="updateProduct(this)">
                            @foreach ($products as $product)
                                 <option value="{{ $product->id }}" data-price="{{ $product->price }}"
                                     data-currency="{{ $product->currency->id }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </td>
                        <td>
                            <input type="number" class="form-control price" name="price[]" step="0.01" readonly>
                        </td>
                        <td>
                            <input type="text" class="form-control currency" name="currency_id[]" readonly>
                        </td>
                        <td>
                            <input type="number" class="form-control quantity" name="quantity[]" min="1"
                                value="1" onchange="updateTotal(this)">
                        </td>
                        <td>
                            <input type="text" class="form-control total" name="total_amount[]" readonly>
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm"
                                onclick="removeProduct(this)">Remove</button>
                        </td>
            `;

            document.getElementById('productRows').appendChild(newRow);
        }

        function removeProduct(button) {
            button.closest('tr').remove();
        }
    </script>
@endsection

@php
    // [['product_id' => 1, price => 12, qut => 12, currency_id => 1, total => 12], ['product_id' => 1, price => 12, qut => 12, currency_id => 1, total => 12]];
@endphp
