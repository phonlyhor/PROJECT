@extends('layouts.master')

@section('title', 'Admin Dashboard')
@section('navbar-title', 'Hello, ' . auth()->user()->name)

@section('content')
<div style="max-width:600px; margin:30px auto; padding:25px; background:#f8f9fa; border-radius:8px; box-shadow:0 4px 10px rgba(0,0,0,0.1);">
    <h2 style="text-align:center; margin-bottom:20px; color:#343a40; font-weight:600;">Edit Category</h2>

    <form action="{{ route('category.update', $Category->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div style="margin-bottom:15px;">
            <label style="display:block; font-weight:500; margin-bottom:5px;">Category Name:</label>
            <input type="text" name="categoryName" value="{{ $Category->CategoryName }}" 
                   style="width:100%; padding:10px; border-radius:5px; border:1px solid #ccc; font-size:14px; box-sizing:border-box;">
        </div>

        <div style="margin-bottom:15px;">
            <label style="display:block; font-weight:500; margin-bottom:5px;">Current Image:</label>
            @if($Category->CategoryImage)
                <img src="{{ asset('img/product/'.$Category->CategoryImage) }}" width="150" 
                     style="margin-top:10px; border-radius:5px; border:1px solid #dee2e6;">
            @else
                <span>No Image</span>
            @endif
        </div>

        <div style="margin-bottom:15px;">
            <label style="display:block; font-weight:500; margin-bottom:5px;">Change Image:</label>
            <input type="file" name="fileCategoryImage" 
                   style="width:100%; padding:10px; border-radius:5px; border:1px solid #ccc; font-size:14px;">
            <input type="hidden" name="oldCategoryImage" value="{{ $Category->CategoryImage }}">
        </div>

        <div style="margin-top:20px;">
            <input type="submit" value="Save" 
                   style="width:100%; padding:12px; background-color:#007bff; color:#fff; font-weight:bold; border:none; border-radius:5px; cursor:pointer; transition:0.3s;">
        </div>
    </form>
</div>
@endsection
