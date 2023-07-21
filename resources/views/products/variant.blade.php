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
                    <li class="breadcrumb-item"><a href="{{ route('product.index') }}">Products</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('product.detail', ['product' => $product]) }}">Detail</a>
                    <li class="breadcrumb-item"><a
                            href="{{ route('product.variant', ['product' => $product]) }}">Variant</a>
                    </li>
                </ol>
            </nav>
            <h2 class="h4">Product Variant</h2>
            <p class="mb-0" style="font-weight: 500">{{ $product->brand_name }} > {{ $product->category_name }} >
                {{ $product->product_name }}</p>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('product.variant.add', ['product' => $product]) }}" class="btn btn-sm btn-gray-800 d-inline-flex align-items-center">
                <svg class="icon icon-xs me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6">
                    </path>
                </svg>
                New Variant
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
        <div class="card-header border-0 d-flex flex-column flex-lg-row align-items-center justify-content-start">
            <div class="mb-0">
                <form action="{{ route('product.variant', ['product' => $product]) }}" method="GET">
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1">
                        <svg class="icon icon-xxs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                        </span>
                        <input type="text" class="form-control" name="q" value="{{ $query }}" placeholder="Search" aria-label="Search">
                    </div>
                </form>
            </div>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-hover table-auto">
                <thead>
                    <tr>
                        <th class="border-gray-200">{{ __('No') }}</th>
                        <th class="border-gray-200">
                            <a href="{{ route('product.variant', ['product' => $product, 'sort' => 'color_name', 'dir' => ($column == 'color_name' && $direction == 'asc') ? 'desc' : 'asc']) }}">
                                Color {!! ($column == 'color_name') ? '<i class="fas fa-sort-' . (($direction == 'asc') ? 'up' : 'down') . '"></i>' : '' !!}
                            </a>
                        </th>
                        <th class="border-gray-200">
                            <a href="{{ route('product.variant', ['product' => $product, 'sort' => 'size', 'dir' => ($column == 'size' && $direction == 'asc') ? 'desc' : 'asc']) }}">
                                Size {!! ($column == 'size') ? '<i class="fas fa-sort-' . (($direction == 'asc') ? 'up' : 'down') . '"></i>' : '' !!}
                            </a>
                        </th>
                        <th class="border-gray-200">
                            <a href="{{ route('product.variant', ['product' => $product, 'sort' => 'base_price', 'dir' => ($column == 'base_price' && $direction == 'asc') ? 'desc' : 'asc']) }}">
                                Base Price {!! ($column == 'base_price') ? '<i class="fas fa-sort-' . (($direction == 'asc') ? 'up' : 'down') . '"></i>' : '' !!}
                            </a>
                        </th>
                        <th class="border-gray-200">
                            <a href="{{ route('product.variant', ['product' => $product, 'sort' => 'disc', 'dir' => ($column == 'disc' && $direction == 'asc') ? 'desc' : 'asc']) }}">
                                Disc (%) {!! ($column == 'disc') ? '<i class="fas fa-sort-' . (($direction == 'asc') ? 'up' : 'down') . '"></i>' : '' !!}
                            </a>
                        </th>
                        <th class="border-gray-200">
                            <a href="{{ route('product.variant', ['product' => $product, 'sort' => 'price', 'dir' => ($column == 'price' && $direction == 'asc') ? 'desc' : 'asc']) }}">
                                Price {!! ($column == 'price') ? '<i class="fas fa-sort-' . (($direction == 'asc') ? 'up' : 'down') . '"></i>' : '' !!}
                            </a>
                        </th>
                        <th class="border-gray-200">
                            <a href="{{ route('product.variant', ['product' => $product, 'sort' => 'option_availability', 'dir' => ($column == 'option_availability' && $direction == 'asc') ? 'desc' : 'asc']) }}">
                                Status {!! ($column == 'option_availability') ? '<i class="fas fa-sort-' . (($direction == 'asc') ? 'up' : 'down') . '"></i>' : '' !!}
                            </a>
                        </th>
                        <th class="border-gray-200">{{ __('#') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ProductOption as $row)
                        <tr>
                            <td><span class="fw-normal">{{ $counter++ }}</span></td>
                            <td><span class="fw-normal">{{ $row->color_name }}</span></td>
                            <td><span class="fw-normal">{{ $row->size }}</span></td>
                            <td style="text-align: right"><span class="fw-normal">{{ $row->base_price }}</span></td>
                            <td style="text-align: right"><span class="fw-normal">{{ $row->disc }}</span></td>
                            <td style="text-align: right"><span class="fw-normal">{{ $row->price }}</span></td>
                            <td>
                                <span class="badge bg-{{ $row->option_availability == 'y' ? 'success' : 'danger' }}">
                                {{ $row->option_availability == 'y' ? 'Available' : 'Not Available' }}
                              </span>
                            </td>
                            <td>
                                <a type="button" class="btn btn-sm btn-primary d-inline-flex align-items-center"
                                    href="{{ route('product.variant.edit', ['product' => $product, 'ProductOption' => $row->id]) }}">
                                    Edit
                                </a>
                                <a type="button" class="btn btn-sm btn-secondary d-inline-flex align-items-center"
                                    href="{{ route('product.variant.delete', ['product' => $product, 'ProductOption' => $row->id]) }}">
                                    Delete
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer px-3 border-0 d-flex flex-column flex-lg-row align-items-center justify-content-end">
            {{ $ProductOption->links() }}
        </div>
    </div>
@endsection
