@extends('layouts.master')

@section('title', 'Admin Dashboard')
@section('navbar-title', 'Hello, ' . auth()->user()->name)

@section('content')

<style>
body {
    font-family: Arial, sans-serif;
    background-color: #f5f6fa;
}

.register {
    max-width: 400px;
    margin:  0 auto;
    padding: 30px;
    background-color: #ffffff;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}

.register h1 {
    text-align: center;
    color: #333;
    margin-bottom: 20px;
}

.register label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
    color: #555;
}

.register input,
.register select {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.register input:focus,
.register select:focus {
    border-color: #007BFF;
    outline: none;
    box-shadow: 0 0 5px rgba(0,123,255,0.3);
}

.register button {
    width: 100%;
    padding: 12px;
    background-color: #007BFF;
    color: #fff;
    font-size: 16px;
    font-weight: bold;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.register button:hover {
    background-color: #0056b3;
}

.register .alert {
    padding: 10px;
    margin-bottom: 15px;
    border-radius: 5px;
    color: #fff;
}

.register .alert-danger {
    background-color: #e74c3c;
}

.register .alert-success {
    background-color: #2ecc71;
}

@media (max-width: 500px) {
    .register {
        margin: 20px;
        padding: 20px;
    }
}
</style>

<div class="register">
    <h1>Add User</h1>

    {{-- Display Success Message --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Display Validation Errors --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul style="margin:0; padding-left:20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

<form action="{{ route('store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <!-- Name -->
    <label>{{ __('messages.name') }}</label>
    <input type="text" name="name" value="{{ old('name') }}">
    @error('name')
        <p style="color:red">{{ $message }}</p>
    @enderror

    <!-- Gender -->
    <label>{{ __('messages.gender') }}</label>
    <select name="gender">
        <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>{{ __('messages.male') }}</option>
        <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>{{ __('messages.female') }}</option>
    </select>
    @error('gender')
        <p style="color:red">{{ $message }}</p>
    @enderror

    <!-- Age -->
    <label>{{ __('messages.age') }}</label>
    <input type="number" name="age" value="{{ old('age') }}">
    @error('age')
        <p style="color:red">{{ $message }}</p>
    @enderror

    <!-- Email -->
    <label>{{ __('messages.email') }}</label>
    <input type="email" name="email" value="{{ old('email') }}">
    @error('email')
        <p style="color:red">{{ $message }}</p>
    @enderror

    <!-- Password -->
    <label>{{ __('messages.password') }}</label>
    <input type="password" name="password">
    @error('password')
        <p style="color:red">{{ $message }}</p>
    @enderror

    <!-- Profile Image -->
    <label>{{ __('messages.profile_image') }}</label>
    <input type="file" name="img">
    @error('img')
        <p style="color:red">{{ $message }}</p>
    @enderror

    <!-- Submit -->
    <button type="submit">{{ __('messages.register') }}</button>
</form>
</div>

@endsection
