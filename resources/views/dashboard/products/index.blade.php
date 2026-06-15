@extends('layouts.master')

@section('title', 'Admin Dashboard')
@section('navbar-title', 'Hello, '. auth()->user()->name)
  <link rel="stylesheet" href="{{ asset('css/product.css') }}">
@section('content')
<style>
  
</style>

<div class="admin-form-container" style="max-width:600px; margin:0 auto; padding:20px; background:#fff; border-radius:8px; box-shadow:0 2px 6px rgba(0,0,0,0.1);">
  <h4 style="margin-top:0; margin-bottom:1.8rem; text-align:center; color:#1f2937;">{{ __('messages.add_product') }}</h4>

  <form action="{{ route('productStore') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <!-- Category -->
    <div class="form-group" style="margin-bottom:15px;">
      <label>{{ __('messages.category') }}</label>
      <select name="CategoryID" class="form-control" required style="width:100%; padding:8px; margin-top:5px;">
        <option value="">{{ __('messages.select_category') }}</option>
        @foreach($Categories as $Category)
          <option value="{{ $Category->id }}" {{ old('CategoryID') == $Category->id ? 'selected' : '' }}>{{ $Category->CategoryName }}</option>
        @endforeach
      </select>
      @error('CategoryID')
        <p style="color:red; margin-top:5px;">{{ $message }}</p>
      @enderror
    </div>

    <!-- Product Name -->
    <div class="form-group" style="margin-bottom:15px;">
      <label>{{ __('messages.product_name') }}</label>
      <input type="text" name="productName" class="form-control" value="{{ old('productName') }}" placeholder="e.g. Wireless Mouse Pro" style="width:100%; padding:8px; margin-top:5px;" required>
      @error('productName')
        <p style="color:red; margin-top:5px;">{{ $message }}</p>
      @enderror
    </div>

    <!-- Price -->
    <div class="form-group" style="margin-bottom:15px;">
      <label>{{ __('messages.price') }} (USD)</label>
      <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price') }}" placeholder="19.99" style="width:100%; padding:8px; margin-top:5px;" required>
      @error('price')
        <p style="color:red; margin-top:5px;">{{ $message }}</p>
      @enderror
    </div>

    <!-- Product Image -->
    <div class="form-group" style="margin-bottom:20px;">
      <label>{{ __('messages.product_image') }}</label>
      <input type="file" name="productImage" class="form-control" accept="image/*" style="width:100%; padding:8px; margin-top:5px;">
      @error('productImage')
        <p style="color:red; margin-top:5px;">{{ $message }}</p>
      @enderror
    </div>

    <!-- Submit -->
    <div style="text-align:center;">
      <button type="submit" style="padding:10px 20px; background:#007bff; color:white; border:none; border-radius:5px; cursor:pointer;">
        {{ __('messages.save_product') }}
      </button>
    </div>
  </form>
</div>
@endsection