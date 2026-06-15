@extends('layouts.master')

@section('title', __('messages.products'))
@section('navbar-title' , __('Hello, ' .auth()->user()->name))

@section('content')

<style>
    .page-wrapper {
    padding: 24px 32px;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    max-width: 1400px;
    margin: 0 auto;
}

.top-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 28px;
    flex-wrap: wrap;
    gap: 16px;
}

.top-bar h2 {
    margin: 0;
    font-size: 1.8rem;
    font-weight: 600;
    color: #1f2937;
}

.btn-primary {
    background: #10b981;
    color: white;
    padding: 10px 20px;
    border-radius: 8px;
    text-decoration: none;
    font-size: 0.95rem;
    font-weight: 500;
    transition: all 0.2s ease;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.btn-primary:hover {
    background: #059669;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(16,185,129,0.3);
}

.filter-box {
    margin-bottom: 24px;
}

.filter-box form {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    align-items: center;
}

.filter-box select,
.filter-box input[type="text"] {
    padding: 10px 14px;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    font-size: 0.95rem;
    min-width: 180px;
    background: white;
}

.filter-box input[type="text"] {
    flex: 1;
    min-width: 220px;
}

.filter-box button {
    padding: 10px 20px;
    background: #3b82f6;
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 500;
    transition: background 0.2s;
}

.filter-box button:hover {
    background: #2563eb;
}

.card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.06);
    overflow: hidden;
}

table {
    width: 100%;
    border-collapse: collapse;
}

thead {
    background: #f8fafc;
}

th, td {
    padding: 14px 16px;
    text-align: left;
    border-bottom: 1px solid #e5e7eb;
}

th {
    font-size: 0.9rem;
    font-weight: 600;
    color: #4b5563;
    text-transform: uppercase;
    letter-spacing: 0.4px;
}

td {
    font-size: 0.95rem;
    color: #374151;
}

.price {
    text-align: right;
    font-weight: 600;
    color: #2563eb;
}

.img-thumb {
    width: 56px;
    height: 56px;
    object-fit: cover;
    border-radius: 8px;
    border: 1px solid #e5e7eb;
    background: #f3f4f6;
}

.action-cell {
    text-align: center;
    white-space: nowrap;
}

.action-btn {
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 0.85rem;
    font-weight: 500;
    text-decoration: none;
    margin: 0 4px;
    transition: all 0.2s;
    display: inline-block;
}

.edit-btn {
    background: #f59e0b;
    color: #92400e;
}

.edit-btn:hover {
    background: #d97706;
    color: white;
}

.delete-btn {
    background: #ef4444;
    color: white;
    border: none;
    cursor: pointer;
}

.delete-btn:hover {
    background: #dc2626;
}

.empty-message {
    text-align: center;
    padding: 60px 20px;
    color: #9ca3af;
    font-size: 1.1rem;
    font-style: italic;
}

/* Pagination */
.pagination {
    margin-top: 24px;
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    gap: 8px;
}

.pagination .page-item {
    margin: 0 2px;
}

.pagination .page-link {
    padding: 8px 14px;
    border-radius: 6px;
    border: 1px solid #d1d5db;
    color: #374151;
    background: white;
    font-size: 0.9rem;
    transition: all 0.2s;
}

.pagination .page-link:hover {
    background: #f3f4f6;
    border-color: #9ca3af;
}

.pagination .page-item.active .page-link {
    background: #3b82f6;
    border-color: #3b82f6;
    color: white;
    font-weight: 500;
}

.pagination .page-item.disabled .page-link {
    color: #9ca3af;
    background: #f3f4f6;
    cursor: not-allowed;
}

@media (max-width: 768px) {
    .top-bar {
        flex-direction: column;
        align-items: flex-start;
    }

    .filter-box form {
        flex-direction: column;
        align-items: stretch;
    }

    .filter-box input[type="text"] {
        min-width: auto;
    }
}
</style>

<div class="page-wrapper">

    <div class="top-bar">
        <h2>{{ __('messages.product_list') }}</h2>
        <a href="{{ url('dashboard/product') }}" class="btn-primary">
            + {{ __('messages.new_product') }}
        </a>
    </div>

    <div class="filter-box">
        <form method="GET" action="{{ route('productList') }}">
            {{-- Preserve existing query params except the ones we control --}}
            @foreach(request()->except('CategoryID', 'search', 'page') as $key => $value)
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endforeach

            <select name="CategoryID" onchange="this.form.submit()">
                <option value="">{{ __('messages.select_category') }}</option>
                @foreach($Categories as $Category)
                    <option value="{{ $Category->id }}"
                        {{ request('CategoryID') == $Category->id ? 'selected' : '' }}>
                        {{ $Category->CategoryName }}
                    </option>
                @endforeach
            </select>

            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   placeholder="{{ __('messages.search_products') }}">

            <button type="submit">{{ __('messages.search') }}</button>
        </form>
    </div>

    <div class="card">
        <table>
            <thead>
                <tr>
                    <th>{{ __('messages.id') }}</th>
                    <th>{{ __('messages.name') }}</th>
                    <th>{{ __('messages.category') }}</th>
                    <th class="price">{{ __('messages.price') }}</th>
                    <th style="text-align:center;">{{ __('messages.image') }}</th>
                    <th style="text-align:center;">{{ __('messages.action') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($Products as $Product)
                    <tr>
                        <td>{{ $Product->id }}</td>
                        <td>{{ $Product->ProductName }}</td>
                        <td>{{ $Product->Category->CategoryName ?? __('messages.no_category') }}</td>
                        <td class="price">៛{{ number_format($Product->Price, 2) }}</td>
                        <td style="text-align:center;">
                            <img src="{{ $Product->ProductImage ? asset('img/product/'.$Product->ProductImage) : 'https://placehold.co/56x56?text=No+Image' }}"
                                 class="img-thumb" alt="{{ $Product->ProductName }}">
                        </td>
                        <td class="action-cell">
                            <a href="{{ route('productsEdit', $Product->id) }}" class="action-btn edit-btn">
                                {{ __('messages.edit') }}
                            </a>

                            <form action="{{ url('dashboard/product/delete/'.$Product->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        onclick="return confirm('{{ __('messages.delete_confirm') }}')"
                                        class="action-btn delete-btn">
                                    {{ __('messages.delete') }}
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="empty-message">
                            {{ __('messages.no_products') }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Fixed pagination -->
        <div class="pagination-wrapper">
         
        </div>
    </div>

</div>

@endsection(fix style.css )