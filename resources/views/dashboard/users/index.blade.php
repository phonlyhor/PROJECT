@extends('layouts.master')

@section('navbar-title', 'Hello, ' . auth()->user()->name)

@section('content')

<style>
    .page-wrapper {
        padding: 20px;
    }

    h1 {
        
        color: #333;
    }

    .top-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .create-btn {
        padding: 8px 14px;
        background-color: #007bff;
        color: #fff;
        border-radius: 5px;
        text-decoration: none;
        font-size: 14px;
        transition: 0.3s;
    }

    .create-btn:hover {
        background-color: #0056b3;
    }

    .success-message {
        background-color: #d4edda;
        color: #155724;
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 15px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        background: #fff;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        border-radius: 8px;
        overflow: hidden;
    }

    table thead {
        background-color: #007bff;
        color: white;
    }

    table th, table td {
        padding: 12px;
        text-align: center;
    }

    table tbody tr:nth-child(even) {
        background-color: #f8f9fa;
    }

    table tbody tr:hover {
        background-color: #e9ecef;
        transition: 0.2s;
    }

    img {
        border-radius: 50%;
        object-fit: cover;
    }

    .empty-row {
        padding: 20px;
        color: #777;
    }
</style>

<div class="page-wrapper">

    <!-- Top bar -->
    <div class="top-bar" style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
        <h1>{{ __('messages.users_list') }}</h1>
        <a href="{{ route('form') }}" class="create-btn" 
           style="padding:8px 15px; background:#007bff; color:white; border-radius:5px; text-decoration:none;">
            + {{ __('messages.create_user') }}
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="success-message" style="padding:10px; background:#d4edda; color:#155724; border-radius:4px; margin-bottom:15px;">
            {{ session('success') }}
        </div>
    @endif

    <!-- Users Table -->
    <table style="width:100%; border-collapse:collapse;">
        <thead>
            <tr style="background:#343a40; color:white;">
                <th style="padding:10px;">No</th>
                <th style="padding:10px;">{{ __('messages.name') }}</th>
                <th style="padding:10px;">{{ __('messages.gender') }}</th>
                <th style="padding:10px;">{{ __('messages.age') }}</th>
                <th style="padding:10px;">{{ __('messages.email') }}</th>
                <th style="padding:10px;">{{ __('messages.image') }}</th>
                <th colspan="2" style="padding:10px;">{{ __('messages.action') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $key => $user)
            <tr style="text-align:center; border-bottom:1px solid #ddd;">
                <td>{{ $key + 1 }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->gender }}</td>
                <td>{{ $user->age }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    @if($user->img)
                        <img src="{{ asset('uploads/users/' . $user->img) }}" width="50" height="50" alt="Profile" style="border-radius:50%;">
                    @else
                        N/A
                    @endif
                </td>
                <td>
                    <a href="{{ route('user.edit', $user->id) }}" 
                       style="padding:5px 10px; background:#28a745; color:white; border-radius:4px; text-decoration:none;">
                        {{ __('messages.edit') }}
                    </a>
                </td>
                <td>
                    <form action="{{ route('user.delete', $user->id) }}" method="POST" 
                          onsubmit="return confirm('{{ __('messages.confirm_delete') }}')" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                            style="padding:5px 10px; background:#dc3545; color:white; border:none; border-radius:4px;">
                            {{ __('messages.delete') }}
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="padding:10px; text-align:center;">{{ __('messages.no_users') }}</td>
            </tr>
            @endforelse
        </tbody>
    </table>

</div>

@endsection
