@extends('layouts.master')

@section('navbar-title', 'Hello, ' . auth()->user()->name)

@section('content')

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f5f6fa;
    }

    .register {
        max-width: 500px;
        margin: 40px auto;
        padding: 30px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    .register h1 {
        text-align: center;
        color: #333;
        margin-bottom: 25px;
        font-size: 26px;
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
        font-size: 14px;
        box-sizing: border-box;
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
        transition: background-color 0.3s ease;
    }

    .register button:hover {
        background-color: #0056b3;
    }

    .register img {
        display: block;
        margin-top: 10px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #007BFF;
    }

    @media (max-width: 600px) {
        .register {
            margin: 20px;
            padding: 20px;
        }
    }
</style>

<div class="register" style="max-width:600px; margin:0 auto; padding:20px; background:#fff; border-radius:8px; box-shadow:0 2px 6px rgba(0,0,0,0.1);">
    <h1 style="text-align:center; margin-bottom:20px;">{{ __('messages.edit_user') }}</h1>

    <form action="{{ route('user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Name -->
        <label>{{ __('messages.name') }}</label>
        <input type="text" name="name" value="{{ old('name', $user->name) }}" style="width:100%; padding:8px; margin-bottom:10px;">
        @error('name')
            <p style="color:red">{{ $message }}</p>
        @enderror

        <!-- Gender -->
        <label>{{ __('messages.gender') }}</label>
        <select name="gender" style="width:100%; padding:8px; margin-bottom:10px;">
            <option value="Male" {{ old('gender', $user->gender) == 'Male' ? 'selected' : '' }}>{{ __('messages.male') }}</option>
            <option value="Female" {{ old('gender', $user->gender) == 'Female' ? 'selected' : '' }}>{{ __('messages.female') }}</option>
        </select>
        @error('gender')
            <p style="color:red">{{ $message }}</p>
        @enderror

        <!-- Age -->
        <label>{{ __('messages.age') }}</label>
        <input type="number" name="age" value="{{ old('age', $user->age) }}" style="width:100%; padding:8px; margin-bottom:10px;">
        @error('age')
            <p style="color:red">{{ $message }}</p>
        @enderror

        <!-- Email -->
        <label>{{ __('messages.email') }}</label>
        <input type="email" name="email" value="{{ old('email', $user->email) }}" style="width:100%; padding:8px; margin-bottom:10px;">
        @error('email')
            <p style="color:red">{{ $message }}</p>
        @enderror

        <!-- Profile Image -->
        <label>{{ __('messages.profile_image') }}</label>
        <input type="file" name="img" style="width:100%; padding:8px; margin-bottom:10px;">
        @if($user->img)
            <div style="margin-bottom:10px;">
                <img src="{{ asset('uploads/users/' . $user->img) }}" width="100" height="100" alt="Profile" style="border-radius:50%;">
            </div>
        @endif
        @error('img')
            <p style="color:red">{{ $message }}</p>
        @enderror

        <!-- Submit -->
        <button type="submit" style="padding:10px 20px; background:#28a745; color:white; border:none; border-radius:5px; cursor:pointer;">
            {{ __('messages.update_user') }}
        </button>
    </form>
</div>

@endsection
