@extends('layouts.master')

@section('title', 'Admin Dashboard')
@section('navbar-title', 'Hello, '. auth()->user()->name)

@section('content')
<style>
    .card-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 20px;
        margin-top: 20px;
    }

    .card {
        background: #ffffff;
        padding: 25px;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        transition: 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 18px rgba(0,0,0,0.08);
    }

    .card h3 {
        margin-bottom: 10px;
        color: #333;
        font-size: 18px;
    }

    .card p {
        font-size: 22px;
        font-weight: bold;
        color: #007bff;
        margin: 0;
    }

    @media (max-width: 600px) {
        .card {
            padding: 20px;
        }
    }
    </style>
  <!-- Current Time Card -->
<div class="card">
    <h3>{{ __('messages.current_time') }}</h3>
    <p id="currentTime" style="font-size: 20px; font-weight: bold; color: #28a745;"></p>
</div>

<script>
    function updateTime() {
        const now = new Date();
        document.getElementById('currentTime').innerText =
            now.toLocaleDateString() + " " + now.toLocaleTimeString();
    }

    setInterval(updateTime, 1000);
    updateTime();
</script>

<!-- Statistics Cards -->
<div class="card-container">
    <div class="card">
        <h3>{{ __('messages.users') }}</h3>
        <p style="font-size: 24px; font-weight: bold; color: #007bff;">
            {{ $totalUsers ?? 0 }} {{ __('messages.users') }}
        </p>
    </div>

    <div class="card">
        <h3>{{ __('messages.categories') }}</h3>
        <p style="font-size: 24px; font-weight: bold; color: #007bff;">
            {{ $totalCategory ?? 0 }} {{ __('messages.categories') }}
        </p>
    </div>

    <div class="card">
        <h3>{{ __('messages.products') }}</h3>
        <p style="font-size: 24px; font-weight: bold; color: #007bff;">
            {{ $totalProduct ?? 0 }} {{ __('messages.products') }}
        </p>
    </div>
    <div class="card">
        <h3>{{ __('messages.admin') }}</h3>
        <p style="font-size: 24px; font-weight: bold; color: #007bff;">
            {{ $totalAdmin ?? 0 }} {{ __('messages.admin') }}
        </p>
    </div>
    {{-- <div class="card">
        <h3>API</h3>
        <a style="font-size: 24px; font-weight: bold; color: #007bff;" href="{{route('api')}}">API</a>
    </div>
        --}}
</div>
@endsection
