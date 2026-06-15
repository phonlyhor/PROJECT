<!-- resources/views/seller/shop.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Lyhor Store</title>
  <link rel="stylesheet" href="{{ asset('css/shop.css') }}">
  <style>
    a{
      color: orange;
      font-size: 20px;
      text-decoration: none;
    }
  </style>
</head>
<body>

<header>
  <nav>
   <a href="{{url('seller/shop')}}"><div class="logo">SELLER</div></a>
       <a href="{{ route('seller.cart.view') }}" class="car">
    My Cart ({{ \App\Models\CartItem::where('user_id', auth()->id())->count() }})
</a>
   <a href="{{route('seller')}}">Logout</a>
  </nav>
</header>

<section class="hero">
<div class="logo">Wellcome to, {{ auth()->user()?->name ?? 'Guest' }}</div>
  <p>Good stuff • Fair prices • Fast delivery</p>
</section>

<!-- Categories -->
<section class="categories">
  @foreach($categories as $category)
    <a href="{{ route('seller.shop', ['CategoryID' => $category->id]) }}" 
       class="category {{ request()->get('CategoryID') == $category->id ? 'active' : '' }}">
      {{ $category->CategoryName }}
    </a>
  @endforeach
</section>


<!-- Products -->
<section class="products">
  @forelse($products as $product)
    <div class="card">
      <img src="{{ $product->ProductImage ? asset('img/product/'.$product->ProductImage) : 'https://via.placeholder.com/200x150' }}" alt="{{ $product->ProductName }}">
      <div class="card-content">
        <h3>{{ $product->ProductName }}</h3>
        <div class="price">៛{{ number_format($product->Price,2) }}</div>
     <form action="{{ route('seller.cart.add', $product->id) }}" method="POST">
    @csrf
    <button type="submit" class="btn">Add to Cart</button>
</form>

      </div>
    </div>
  @empty
    <p>No products available in this category.</p>
  @endforelse
</section>



</body>
</html>