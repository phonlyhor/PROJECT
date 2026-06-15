<!-- resources/views/layouts/dashboard.blade.php -->
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', __('messages.welcome'))</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <style>
        /* Reset & base styles */
        * { box-sizing: border-box; margin:0; padding:0; font-family: Arial, sans-serif; }
        body { display:flex; min-height:100vh; background-color:#f4f6f8; }

        /* Sidebar */
        .sidebar { width:250px; background-color:#2c3e50; color:#ecf0f1; flex-shrink:0; display:flex; flex-direction:column; }
        .sidebar h2 { text-align:center; padding:20px 0; border-bottom:1px solid #34495e; }
        .sidebar a { padding:15px 20px; text-decoration:none; color:#ecf0f1; transition: background 0.3s; }
        .sidebar a:hover { background-color:#34495e; }

        .sidebar-item { list-style:none; margin-bottom:5px; position:relative; }
        .sidebar-item > a { display:flex; align-items:center; text-decoration:none; padding:10px 20px; border-radius:5px; transition:0.3s; }
        .sidebar-item > a:hover { background-color:#34495e; color:#fff; }
        .sidebar-item .arrow { margin-left:10px; font-size:12px; }
        .dropdown-menu { display:none; list-style:none; padding-left:0; margin-top:5px; }
        .dropdown-menu li a { display:block; padding:8px 25px; text-decoration:none; color:orange; border-radius:5px; transition:0.3s; }
        .dropdown-menu li a:hover { background-color:#34495e; color:#fff; }
        .sidebar-item:hover .dropdown-menu { display:block; }

        /* Main content */
        .main-content { flex:1; display:flex; flex-direction:column; }

        /* Navbar */
        .navbar { height:60px; background-color:#fff; display:flex; align-items:center; padding:0 20px; box-shadow:0 2px 4px rgba(0,0,0,0.1); }
        .navbar h1 { font-size:20px; color:#333; }
        .navbar .navbar-right { margin-left:auto; display:flex; align-items:center; gap:15px; }

        /* Logout button */
        .btn { padding:8px 12px; background-color:red; border:none; color:white; cursor:pointer; border-radius:4px; }

        /* Language links */
        .navbar a { color:#2c3e50; font-weight:bold; text-decoration:none; }
        .navbar a:hover { color:#e74c3c; }

        /* Dashboard content */
        .content { padding:20px; flex:1; }

        /* Responsive */
        @media(max-width:768px) {
            body { flex-direction:column; }
            .sidebar { width:100%; flex-direction:row; overflow-x:auto; }
            .sidebar a { flex:1; text-align:center; padding:15px 10px; }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h2><i class="fas fa-tachometer-alt"></i> {{ __('messages.dashboard') }}</h2>
        <a href="{{ route('dashboard') }}"><i class="fas fa-home"></i> {{ __('messages.dashboard') }}</a>
        <a href="{{ route('user') }}"><i class="fas fa-user"></i> {{ __('messages.user') }}</a>

        <li class="sidebar-item">
            <a href="#"><i class="fas fa-box"></i> {{ __('messages.categories') }} <span class="arrow">&#9662;</span></a>
            <ul class="dropdown-menu">
                <li><a href="{{ route('category.create') }}">{{ __('messages.add_category') }}</a></li>
                <li><a href="{{ route('category.list') }}">{{ __('messages.category_list') }}</a></li>
            </ul>
        </li>

        <li class="sidebar-item">
            <a href="#"><i class="fas fa-box"></i> {{ __('messages.products') }} <span class="arrow">&#9662;</span></a>
            <ul class="dropdown-menu">
                <li><a href="{{ route('products') }}">{{ __('messages.add_product') }}</a></li>
                <li><a href="{{ route('productList') }}">{{ __('messages.product_list') }}</a></li>
            </ul>
        </li>
        <li><a href="{{route('seller')}}">Shopping</a></li>
        
    </div>

    <!-- Main content -->
    <div class="main-content">
        <!-- Navbar -->
        <div class="navbar">
            <h1>@yield('navbar-title', __('messages.welcome'))</h1>
            <div class="navbar-right">
                <!-- Language switcher -->
                <a href="{{ route('switch.language', ['lang' => 'kh']) }}">ខ្មែរ</a> |
                <a href="{{ route('switch.language', ['lang' => 'en']) }}">English</a> |
                <a href="{{ route('switch.language', ['lang' => 'ch']) }}">China</a>

                <!-- Logout button -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn" type="submit">
                        <i class="fas fa-sign-out-alt"></i> {{ __('messages.logout') }}
                    </button>
                </form>
            </div>
        </div>

        <!-- Content -->
        <div class="content">
            @yield('content')
        </div>
    </div>
</body>
</html>