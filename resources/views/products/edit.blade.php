@extends('layouts.app')

@section('body')
    <div class="container">
        <h1>Edit Product</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $product->name }}" required>
            </div>

            <div class="form-group">
                <label for="barcode">Barcode</label>
                <input type="text" class="form-control" id="barcode" name="barcode" value="{{ $product->barcode }}"
                    required>
            </div>

            <div class="form-group">
                <label for="category_id">Category</label>
                <select class="form-control" id="category_id" name="category_id" required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ $category->id == $product->category_id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" rows="4">{{ $product->description }}</textarea>
            </div>

            <div class="form-group">
                <label for="image">Current Image</label>
                @if ($product->image)
                    <div>
                        <img src="{{ asset('/storage/' . $product->image) }}" alt="Product Image" class="img-thumbnail"
                            style="max-width: 100px;">
                    </div>
                @else
                    <div>No Image</div>
                @endif
            </div>

            <div class="form-group">
                <label for="new_image">New Image</label>
                <input type="file" class="form-control-file" id="new_image" name="new_image">
            </div>

            <div class="form-group">
                <label for="keywords">Keywords</label>
                <input type="text" class="form-control" id="keywords" name="keywords" value="{{ $product->keywords }}">
            </div>

            <div class="form-group">
                <label for="active">Active</label>
                <select class="form-control" id="active" name="active">
                    <option value="0" {{ $product->active == 'inactive' ? 'selected' : '' }}>inactive</option>
                    <option value="1" {{ !$product->active == 'activated' ? 'selected' : '' }}>activated</option>
                </select>
            </div>

            <div class="form-group">
                <label for="currency_id">Currency</label>
                <select class="form-control" id="currency_id" name="currency_id" required>
                    @foreach ($currencies as $currency)
                        <option value="{{ $currency->id }}" data-decimal-digits="{{ $currency->decimal_digits }}">
                            {{ $currency->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" class="form-control" id="price" name="price" step="0.01" required>
                <span class="error" style="color: red; display: none;">Allowed price exceeded</span>
            </div>

            <button type="submit" class="btn btn-primary">Update Product</button>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>


@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {

            const priceInput = $('#price');
            const priceError = $('.error');
            const currencySelect = $('#currency_id');

            priceInput.on('input', function() {
                const inputValue = priceInput.val();
                const selectedCurrency = currencySelect.find(':selected');
                const decimalDigitsAllowed = parseInt(selectedCurrency.data('decimal-digits'));

                if (inputValue.length > decimalDigitsAllowed) {
                    priceError.css('display', 'block');
                    priceInput.val(inputValue.substring(0, decimalDigitsAllowed));
                } else {
                    priceError.css('display', 'none');
                }
            });

            priceInput.trigger('input');
        });
    </script>
@endsection
