<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Product Form</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">

<div class="container">
    <h1 class="mb-4">Add Product</h1>

    <!-- Product Form -->
    <form id="productForm" class="mb-4">
        <div class="row g-3">
            <div class="col-md-4">
                <input type="text" name="name" id="name" class="form-control" placeholder="Product Name" required>
            </div>
            <div class="col-md-3">
                <input type="number" name="quantity" id="quantity" class="form-control" placeholder="Quantity" required min="0">
            </div>
            <div class="col-md-3">
                <input type="number" name="price" id="price" class="form-control" placeholder="Price" required step="0.01" min="0">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Add</button>
            </div>
        </div>
    </form>

    <!-- Product Table -->
    <h2 class="mb-3">Product List</h2>
    <table class="table table-bordered" id="productsTable">
        <thead class="table-light">
            <tr>
                <th>Name</th>
                <th>Quantity</th>
                <th>Price per item</th>
                <th>Datetime submitted</th>
                <th>Total value</th>
            </tr>
        </thead>
        <tbody id="productRows">
            @php $total = 0; @endphp
            @foreach($products as $product)
                @php
                    $value = $product->quantity * $product->price;
                    $total += $value;
                @endphp
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->quantity }}</td>
                    <td>{{ number_format($product->price, 2) }}</td>
                    <td>{{ $product->created_at }}</td>
                    <td>{{ number_format($value, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="table-secondary">
                <th colspan="4" class="text-end">Total:</th>
                <th id="totalValue">{{ number_format($total, 2) }}</th>
            </tr>
        </tfoot>
    </table>
</div>

<script>
    const form = document.getElementById('productForm');
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        const name = document.getElementById('name').value.trim();
        const quantity = document.getElementById('quantity').value;
        const price = document.getElementById('price').value;

        fetch('/products', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token
            },
            body: JSON.stringify({ name, quantity, price })
        })
        .then(response => {
            if (!response.ok) throw new Error("Network error or validation failed.");
            return response.json();
        })
        .then(data => {
            if (data.product) {
                const table = document.getElementById('productRows');
                const row = document.createElement('tr');

                const value = parseFloat(data.product.quantity) * parseFloat(data.product.price);

                row.innerHTML = `
                    <td>${data.product.name}</td>
                    <td>${data.product.quantity}</td>
                    <td>${parseFloat(data.product.price).toFixed(2)}</td>
                    <td>${data.product.created_at}</td>
                    <td>${value.toFixed(2)}</td>
                `;

                table.appendChild(row);

                // Обновим сумму
                const totalCell = document.getElementById('totalValue');
                const currentTotal = parseFloat(totalCell.textContent) || 0;
                totalCell.textContent = (currentTotal + value).toFixed(2);

                form.reset();
            }
        })
        .catch(error => {
            alert("Failed to add product. Check your input and try again.");
            console.error(error);
        });
    });
</script>

</body>
</html>
