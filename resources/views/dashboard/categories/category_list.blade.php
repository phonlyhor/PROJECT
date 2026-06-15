@extends('layouts.master')

@section('title', 'Admin Dashboard')
@section('navbar-title', 'Hello, ' . auth()->user()->name)

@section('content')

<h3 style="margin-bottom:20px; color:#333;">{{ __('messages.category_list') }}</h3>

<!-- Success message -->
@if(session('success'))
    <div style="color:green; margin-bottom:15px;">
        {{ session('success') }}
    </div>
@endif

<table style="width:100%; border-collapse:collapse; box-shadow:0 2px 8px rgba(0,0,0,0.05); border-radius:8px; overflow:hidden;">
    <thead style="background-color:#007bff; color:#fff;">
        <tr>
            <th style="padding:10px; text-align:center;">ID</th>
            <th style="padding:10px; text-align:center;">{{ __('messages.category_name') }}</th>
            <th style="padding:10px; text-align:center;">{{ __('messages.image') }}</th>
            <th colspan="2" style="padding:10px; text-align:center;">{{ __('messages.action') }}</th>
        </tr>
    </thead>
    <tbody>
        @forelse($categories as $c)
        <tr style="text-align:center; border-bottom:1px solid #ddd;">
            <td style="padding:10px;">{{ $c->id }}</td>
            <td style="padding:10px;">{{ $c->CategoryName }}</td>
            <td style="padding:10px;">
                @if($c->CategoryImage)
                    <img src="{{ asset('img/product/' . $c->CategoryImage) }}" width="80" style="border-radius:5px;" alt="Category Image">
                @else
                    <span style="color:#777;">{{ __('messages.no_image') }}</span>
                @endif
            </td>
            <td>
                <a href="{{ route('showEdit', $c->id) }}" style="color:#007bff;">{{ __('messages.edit') }}</a>
            </td>
            <td>
                <form action="{{ route('category.destroy', $c->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('{{ __('messages.confirm_delete') }}')">
                    @csrf
                    @method('DELETE')
                    <button style="color:#dc3545; border:none; background:none; cursor:pointer;">{{ __('messages.delete') }}</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5" style="padding:15px; color:#777; text-align:center;">{{ __('messages.no_categories') }}</td>
        </tr>
        @endforelse
    </tbody>
</table>

@endsection
