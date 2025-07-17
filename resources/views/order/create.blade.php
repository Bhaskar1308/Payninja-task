<!DOCTYPE html>
<html>
<head>
    <title>Place an Order</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .card {
            border-radius: 1rem;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .form-section-title {
            margin-top: 30px;
            margin-bottom: 15px;
            font-weight: bold;
            font-size: 1.25rem;
            color: #343a40;
        }

        .product-item input {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card p-4">
                <h3 class="text-center mb-4"> Place a New Order</h3>

                {{-- Alert Messages --}}
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                {{-- Order Form --}}
                <form method="POST" action="{{ route('order.store') }}">
                    @csrf

                    <div class="form-group mb-3">
                        <label for="customer_name" class="form-label"> Customer Name</label>
                        <input type="text" name="customer_name" class="form-control" placeholder="Enter customer name" required>
                    </div>

                    <div class="form-section-title"> Products</div>
                    <div id="product-list">
                        <div class="row g-2 mb-2 product-item">
                            <div class="col-md-4">
                                <input type="text" name="products[0][name]" class="form-control" placeholder="Product Name" required>
                            </div>
                            <div class="col-md-3">
                                <input type="number" name="products[0][quantity]" class="form-control" placeholder="Quantity" required>
                            </div>
                            <div class="col-md-3">
                                <input type="number" name="products[0][price]" class="form-control" placeholder="Price" required>
                            </div>
                            <div class="col-md-2 d-flex align-items-center">
                                <button type="button" class="btn btn-danger btn-sm remove-product">✖</button>
                            </div>
                        </div>
                    </div>

                    <div class="text-end mb-3">
                        <button type="button" class="btn btn-outline-primary btn-sm" onclick="addProduct()">➕ Add More Product</button>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-success btn-lg"> Submit Order</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
let productIndex = 1;

function addProduct() {
    const row = `
    <div class="row g-2 mb-2 product-item">
        <div class="col-md-4">
            <input type="text" name="products[${productIndex}][name]" class="form-control" placeholder="Product Name" required>
        </div>
        <div class="col-md-3">
            <input type="number" name="products[${productIndex}][quantity]" class="form-control" placeholder="Quantity" required>
        </div>
        <div class="col-md-3">
            <input type="number" name="products[${productIndex}][price]" class="form-control" placeholder="Price" required>
        </div>
        <div class="col-md-2 d-flex align-items-center">
            <button type="button" class="btn btn-danger btn-sm remove-product">✖</button>
        </div>
    </div>
    `;
    document.getElementById('product-list').insertAdjacentHTML('beforeend', row);
    productIndex++;
}

// Remove product row
document.addEventListener('click', function(e) {
    if (e.target && e.target.classList.contains('remove-product')) {
        e.target.closest('.product-item').remove();
    }
});
</script>
</body>
</html>
