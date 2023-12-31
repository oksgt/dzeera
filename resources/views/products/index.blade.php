@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}">
                            <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                </path>
                            </svg>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="{{ route('product.index') }}">Product</a></li>
                </ol>
            </nav>
            <h2 class="h4">Product</h2>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('product.create') }}" class="btn btn-sm btn-gray-800 d-inline-flex align-items-center">
                <svg class="icon icon-xs me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6">
                    </path>
                </svg>
                New Product
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session()->has('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>
    </div>

    <div class="card card-body border-0 shadow table-wrapper ">
        <div class="card-header border-0 d-flex flex-column flex-lg-row align-items-center justify-content-end p-0 mb-2">
            <form action="{{ route('product.index') }}" method="GET">
                <div class="input-group">
                    <span class="input-group-text" id="basic-addon1">
                    <svg class="icon icon-xxs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                    </span>
                    <input type="text" class="form-control" name="q" value="{{ $query }}" placeholder="Search" aria-label="Search">
                </div>
            </form>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover table-sm">
                <thead>
                    <tr>
                        <th class="border-gray-200">{{ __('No') }}</th>
                        <th class="border-gray-200">
                            <a href="{{ route('product.index', ['sort' => 'category_name', 'dir' => ($column == 'category_name' && $direction == 'asc') ? 'desc' : 'asc']) }}">
                                Name {!! ($column == 'category_name') ? '<i class="fas fa-sort-' . (($direction == 'asc') ? 'up' : 'down') . '"></i>' : '' !!}
                            </a>
                        </th>
                        <th class="border-gray-200">
                            <a href="{{ route('product.index', ['sort' => 'brand_name', 'dir' => ($column == 'brand_name' && $direction == 'asc') ? 'desc' : 'asc']) }}">
                                Brand {!! ($column == 'brand_name') ? '<i class="fas fa-sort-' . (($direction == 'asc') ? 'up' : 'down') . '"></i>' : '' !!}
                            </a>
                        </th>
                        <th class="border-gray-200">
                            <a href="{{ route('product.index', ['sort' => 'category_name', 'dir' => ($column == 'category_name' && $direction == 'asc') ? 'desc' : 'asc']) }}">
                                Category {!! ($column == 'category_name') ? '<i class="fas fa-sort-' . (($direction == 'asc') ? 'up' : 'down') . '"></i>' : '' !!}
                            </a>
                        </th>
                        <th class="border-gray-200">
                            <a href="{{ route('product.index', ['sort' => 'rating', 'dir' => ($column == 'rating' && $direction == 'asc') ? 'desc' : 'asc']) }}">
                                Rating {!! ($column == 'rating') ? '<i class="fas fa-sort-' . (($direction == 'asc') ? 'up' : 'down') . '"></i>' : '' !!}
                            </a>
                        </th>
                        <th class="border-gray-200">
                            <a href="{{ route('product.index', ['sort' => 'highlight', 'dir' => ($column == 'highlight' && $direction == 'asc') ? 'desc' : 'asc']) }}">
                                Highlight {!! ($column == 'highlight') ? '<i class="fas fa-sort-' . (($direction == 'asc') ? 'up' : 'down') . '"></i>' : '' !!}
                            </a>
                        </th>
                        <th class="border-gray-200">
                            <a href="{{ route('product.index', ['sort' => 'product_status', 'dir' => ($column == 'product_status' && $direction == 'asc') ? 'desc' : 'asc']) }}">
                                Status {!! ($column == 'product_status') ? '<i class="fas fa-sort-' . (($direction == 'asc') ? 'up' : 'down') . '"></i>' : '' !!}
                            </a>
                        </th>
                        <th class="border-gray-200">
                            <a href="{{ route('product.index', ['sort' => 'product_availability', 'dir' => ($column == 'product_availability' && $direction == 'asc') ? 'desc' : 'asc']) }}">
                                Available {!! ($column == 'product_availability') ? '<i class="fas fa-sort-' . (($direction == 'asc') ? 'up' : 'down') . '"></i>' : '' !!}
                            </a>
                        </th>
                        <th class="border-gray-200">{{ __('#') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td><span class="fw-normal">{{ $counter++ }}</span></td>
                            <td><span class="fw-normal">{{ $product->product_name }}</span></td>
                            <td><span class="fw-normal">{{ $product->brand_name }}</span></td>
                            <td><span class="fw-normal">{{ $product->category_name }}</span></td>
                            <td><span class="fw-normal"><i class="fas fa-star text-warning"></i> {{ $product->rating }}</span></td>
                            <td>
                                <span class="badge bg-{{ $product->highlight == 'y' ? 'success' : 'warning' }}">
                                {{ $product->highlight == 'y' ? 'Yes' : 'No' }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $product->product_status == 'ready' ? 'success' : 'warning' }}">
                                {{ $product->product_status == 'ready' ? 'Ready' : 'Pre Order' }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $product->product_availability == 'y' ? 'success' : 'warning' }}">
                                {{ $product->product_availability == 'y' ? 'Yes' : 'No' }}
                                </span>
                            </td>
                            <td>
                                <a type="button" class="btn btn-sm btn-warning border-0 float-end align-items-center"
                                title="Detail"
                                    href="{{ route('product.detail', ['product' => $product->id]) }}">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer px-3 border-0 d-flex flex-column flex-lg-row align-items-center justify-content-between">
            {{ $products->links() }}
        </div>
    </div>
@endsection

