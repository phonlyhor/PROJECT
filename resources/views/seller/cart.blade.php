<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart - Lyhor Store</title>
    <link rel="stylesheet" href="{{ asset('css/shop.css') }}">

    <style>
    body {
        font-family: system-ui, -apple-system, sans-serif;
        background: #f8f9fa;
        color: #333;
        margin: 0;
        line-height: 1.6;
    }

    header nav {
        background: #222;
        padding: 1rem 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .logo { color: white; font-size: 1.6rem; font-weight: bold; }

    .car {
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 6px;
    }

    .cart {
        max-width: 980px;
        margin: 3rem auto;
        padding: 0 1.5rem;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        padding: 12px;
        text-align: center;
        border: 1px solid #ddd;
        background: #fff;
    }

    th {
        background: #ff9800;
        color: white;
    }

    td img {
        width: 60px;
        height: 60px;
        object-fit: cover;
    }

    button {
        padding: 6px 12px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .btn-print {
        background: #4caf50;
        color: white;
        margin-top: 20px;
    }

    .btn-remove {
        background: #e53935;
        color: white;
    }

    .empty-cart {
        text-align: center;
        margin: 5rem 0;
        padding: 2rem;
        background: #fff0f0;
        border: 2px dashed #ef9a9a;
    }

    /* Hide buttons when printing */
    @media print {
        button, a {
            display: none;
        }
    }
    </style>
</head>

<body>

<header>
    <nav>
        <a href="{{ route('seller.shop') }}">
            <div class="logo">SELLER</div>
        </a>

        <a href="{{ route('seller.cart.view') }}" class="car">
            My Cart ({{ \App\Models\CartItem::where('user_id', auth()->id())->count() }})
        </a>
    </nav>
</header>

<section class="cart">
    <h2>Your Cart</h2>

    @if($cart->count() > 0)
        <table id="receiptTable">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @php $grandTotal = 0; @endphp

                @foreach($cart as $item)
                    @php
                        $total = $item->price * $item->quantity;
                        $grandTotal += $total;
                    @endphp

                    <tr>
                        <td>
                            <img src="{{ $item->image ? asset('img/product/'.$item->image) : 'https://via.placeholder.com/60x60' }}">
                        </td>
                        <td>{{ $item->name }}</td>
                        <td>៛{{ number_format($item->price, 2) }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>៛{{ number_format($total, 2) }}</td>
                        <td>
                            <form action="{{ route('seller.cart.remove', $item->product_id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn-remove">Remove</button>
                            </form>
                        </td>
                    </tr>
                @endforeach

                <tr>
                    <td colspan="4"><strong>Total</strong></td>
                    <td colspan="2">
                        <strong>៛{{ number_format($grandTotal, 2) }}</strong>
                    </td>
                </tr>
            </tbody>
        </table>

        <br>

        <!-- Checkout -->
        <a href="{{ route('seller.checkout', $item->product_id) }}" class="btn btn-primary">
            Add Payments
        </a>

        <!-- PRINT BUTTON -->
        <br><br>
        <button onclick="printReceipt()" class="btn-print">
            Print Receipt
        </button>

    @else
        <div class="empty-cart">
            Your cart is empty.
        </div>
    @endif
</section>

<!-- PRINT SCRIPT -->
<script>
function printReceipt() {
    var table = document.getElementById('receiptTable').outerHTML;
    var date = new Date().toLocaleString();

    var printWindow = window.open('', '', 'width=800,height=600');

    printWindow.document.write(`
        <html>
        <head>
            <title>Receipt</title>
            <style>
                body {
                    font-family: Arial;
                    padding: 20px;
                }
                h2 {
                    text-align: center;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-top: 20px;
                }
                th, td {
                    border: 1px solid black;
                    padding: 8px;
                    text-align: center;
                }
                th {
                    background: #f2f2f2;
                }
                .info {
                    margin-bottom: 10px;
                }
            </style>
        </head>

        <body>
            <h2>Lyhor Store Receipt</h2>
            <div class="info">Date: ${date}</div>

            ${table}

            <h3 style="text-align:center;">Thank you for your purchase!</h3>
        </body>
        </html>
    `);

    printWindow.document.close();
    printWindow.print();
}
</script>

</body>
</html>