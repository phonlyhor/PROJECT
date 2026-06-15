@extends('layouts.master')

@section('title', __('messages.products'))
@section('navbar-title', __('messages.Hello'. auth()->user()->name))

@section('content')
<style>
    /* Admin Dashboard Form Styling */
    .edit-card {
        width: 900px;
        margin: auto;
        border: none;
        border-radius: 12px;
        box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.1);
        background: #fff;
    }

    .card-header {
        background-color: #f8f9fc;
        border-bottom: 1px solid #e3e6f0;
        padding: 1.5rem;
        border-top-left-radius: 12px !important;
        border-top-right-radius: 12px !important;
    }

    .card-header h4 {
        color: #4e73df;
        font-weight: 700;
    }

    .card-header small {
        color: #858796;
        font-weight: 400;
    }

    .form-label {
        font-weight: 600;
        color: #5a5c69;
        margin-bottom: 0.5rem;
    }

    .form-control, .form-select {
        border-radius: 8px;
        padding: 0.6rem 1rem;
        border: 1px solid #d1d3e2;
        transition: all 0.2s;
    }

    .form-control:focus, .form-select:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.1);
    }

    .image-preview-wrapper {
        background: #f8f9fc;
        padding: 15px;
        border-radius: 8px;
        border: 1px dashed #d1d3e2;
        display: inline-block;
        width: 100%;
    }

    .img-thumbnail-custom {
        object-fit: cover;
        border-radius: 6px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .btn-save {
        margin-left: 60px;
        background-color: #4e73df;
        border: none;
        padding: 0.6rem 1.5rem;
        font-weight: 0;
        border-radius: 8px;
        transition: all 0.3s;
        color: #fff;
    }

    .btn-save:hover {
        background-color: #2e59d9;
        transform: translateY(-1px);
    }

    .btn-back {
        margin-left: 15px;
        text-decoration: none;
        background-color: #eaecf4;
        color: #5a5c69;
        border: none;
        padding: 0.6rem 1.5rem;
        font-weight: 600;
        border-radius: 8px;
        transition: all 0.2s;
    }
    
    .btn-back:hover {
        background-color: #d1d3e2;
    }

    hr {
        opacity: 0.1;
    }
</style>

<div class="container mt-5 mb-5">
    <div class="card mx-auto edit-card" style="max-width:600px;">
        <div class="card-header text-center">
            <h4 class="m-0">{{ __('messages.edit_product') }}</h4>
            <small class="text-muted">{{ __('messages.modify_inventory') }}</small>
        </div>

        <div class="card-body p-4">
            <form action="{{ route('pro') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $Product->id }}">

                <!-- Category -->
                <div class="mb-4">
                    <label class="form-label">{{ __('messages.category') }}</label>
                    <select name="CategoryID" class="form-select" required>
                        @foreach($Categories as $Category)
                            <option value="{{ $Category->id }}" {{ $Product->CategoryID == $Category->id ? 'selected' : '' }}>
                                {{ $Category->CategoryName }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Product Name -->
                <div class="mb-4">
                    <label class="form-label">{{ __('messages.product_name') }}</label>
                    <input type="text" name="productName" value="{{ $Product->ProductName }}" class="form-control" required placeholder="{{ __('messages.product_placeholder') }}">
                </div>

                <!-- Price -->
                <div class="mb-4">
                    <label class="form-label">{{ __('messages.price_usd') }}</label>
                    <input type="number" name="price" value="{{ $Product->Price }}" step="0.01" class="form-control" required placeholder="0.00">
                </div>

                <!-- Product Image -->
                <div class="mb-4">
                    <label class="form-label d-block">{{ __('messages.product_image') }}</label>
                    <div class="mb-3">
                        <input type="file" name="productImage" class="form-control">
                    </div>

                    <div class="image-preview-wrapper text-center">
                        @if(!empty($Product->ProductImage))
                            <img src="{{ asset('img/product/'.$Product->ProductImage) }}" width="150" height="150" class="img-thumbnail-custom mb-2">
                            <div class="small text-muted">{{ __('messages.current_file') }}: {{ $Product->ProductImage }}</div>
                        @else
                            <div class="py-3 px-5 border rounded bg-white">
                                <i class="fas fa-image text-muted mb-2 d-block" style="font-size: 2rem;"></i>
                                <small class="text-muted">{{ __('messages.no_preview') }}</small>
                            </div>
                        @endif
                    </div>
                </div>

                <hr>

                <!-- Buttons -->
                <div class="d-flex justify-content-between">
                    <a href="{{ route('productList') }}" class="btn btn-back">
                        <i class="fas fa-chevron-left me-1"></i> {{ __('messages.back') }}
                    </a>
                    <button type="submit" class="btn btn-save">
                        <i class="fas fa-save me-1"></i> {{ __('messages.save_changes') }}
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection