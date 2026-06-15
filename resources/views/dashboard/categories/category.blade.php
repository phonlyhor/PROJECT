@extends('layouts.master')

@section('title', 'Admin Dashboard')
@section('navbar-title', 'Hello, '. auth()->user()->name )

@section('content')
  <link rel="stylesheet" href="{{ asset('css/category.css') }}">
<style>
    
</style>

@if ($errors->any())
    <div class="error-messages">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('success'))
    <div class="success-message">{{ session('success') }}</div>
@endif

<div class="panel" style="max-width:500px; margin:0 auto; padding:20px; background:#fff; border-radius:8px; box-shadow:0 2px 6px rgba(0,0,0,0.1);">
    <h3 style="margin-bottom:20px; text-align:center; color:#333;">{{ __('messages.create_category') }}</h3>

    <form action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Category Name -->
        <div class="form-group" style="margin-bottom:15px;">
            <label>{{ __('messages.category_name') }}:</label>
            <input type="text" name="CategoryName" value="{{ old('CategoryName') }}" style="width:100%; padding:8px; margin-top:5px;">
            @error('CategoryName')
                <p style="color:red; margin-top:5px;">{{ $message }}</p>
            @enderror
        </div>

        <!-- Category Image -->
        <div class="form-group" style="margin-bottom:15px;">
            <label>{{ __('messages.category_image') }}:</label>
            <input type="file" name="CategoryImage" style="width:100%; padding:8px; margin-top:5px;">
            @error('CategoryImage')
                <p style="color:red; margin-top:5px;">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submit Button -->
        <div class="form-group" style="text-align:center;">
            <button type="submit" style="padding:10px 20px; background:#007bff; color:white; border:none; border-radius:5px; cursor:pointer;">
                {{ __('messages.save') }}
            </button>
        </div>
    </form>
</div>



@endsection