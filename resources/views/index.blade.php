<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Product From</title>
</head>
<body class="p-4">
    <div class="container">
        <h2>Add product</h2>
        <form action="{{ route('products.store')}}" id="product-form" method="POST">
            @csrf
            <div class="mb-2">
                <input type="text" name="name" class="form-control" placeholder="Product name" required>
            </div>
            <div class="mb-2">
                <input type="number" name="quantity" class="form-control" placeholder="Quantity in stock" required>
            </div>
            <div class="mb-2">
                <input type="number" step="0.01" name="price" class="form-control" placeholder="Price per item" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

        <hr>

        <h3>Submitted Products</h3>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Product name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Datetime submitted</th>
                    <th>Total value</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach ($products as $product)
                    @php
                        $value = $product->quantity * $product->price; 
                        $total += $value;
                    @endphp
                     <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->quantity }}</td>
                        <td>{{ $product->price }}</td>
                        <td>{{ $product->created_at }}</td>
                        <td>{{ number_format($value, 2) }}</td>
                    </tr>
                    @endforeach
                    <tr class="table-secondary fw-bold">
                        <td colspan="4" class="text-end">Total:</td>
                        <td>{{ number_format($total, 2) }}</td>
                    </tr>
            </tbody>
        </table>
    </div>

    <script src="{{asset('js/app.js')}}"></script>
</body>
</html>