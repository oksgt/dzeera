@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-md-0">
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
                    <li class="breadcrumb-item"><a href="{{ route('product.color', ['product' => $product]) }}">Color</a>
                    </li>
                </ol>
            </nav>
            <h2 class="h4">Product Color Management</h2>
            <p class="mb-0">Product color option for {{ $product->product_name }}</p>
        </div>
        <div class="btn-toolbar mb-md-0">
            <a href="{{ route('product.color.create',['product' => $product]) }}" class="btn btn-sm btn-gray-800 d-inline-flex align-items-center">
                <svg class="icon icon-xs me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6">
                    </path>
                </svg>
                New Color
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


    <div class="row">
        <div class="col-md-12 col-lg-12 mb-4">
            <div class="card">
                <div class="card-body d-flex justify-content-center">
                    <div class="col-md-12 col-lg-8 table-responsive">
                        <table class="table ">
                            <thead>
                                <tr>
                                    <th class="border-gray-200">{{ __('No') }}</th>
                                    <th>
                                        Color Name
                                    </th>
                                    <th class="border-gray-200">{{ __('#') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!empty($ProductColorOption))
                                    @foreach ($ProductColorOption as $row)
                                        <tr>
                                            <td><span class="fw-normal">{{ $counter++ }}</span></td>
                                            <td><span class="fw-normal">{{ $row->color_name }}</span></td>
                                            <td>
                                                <a type="button" class="btn btn-sm btn-primary border-0 align-items-center"
                                                    href="{{ route('product.color.edit', ['product' => $product, 'ProductColorOption' => $row]) }}">
                                                    Edit
                                                </a>
                                                <a type="button" class="btn btn-sm btn-secondary d-inline-flex align-items-center"
                                                    href="{{ route('product.color.delete', ['product' => $product, 'ProductColorOption' => $row]) }}">
                                                    Delete
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="justify-content-start">
                        <a class="btn btn-sm btn-gray-100 " type="button" id="button-back"
                            href="{{ route('product.detail', ['product' => $product]) }}">Back</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // var product_desc = {{ $product->product_desc }};
        tinymce.get('product_desc').setContent('ss');
    </script>
@endpush
