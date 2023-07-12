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
                    </li>
                </ol>
            </nav>
            <h2 class="h4">Detail Product</h2>
            <p class="mb-0">Product data form</p>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            @if (session()->has('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>
    </div>

    <div class="row ">
        <div class="col-md-8 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3 p-1">

                        <form action="{{ route('product.save') }}" method="post">
                            @csrf

                            <label for="product_name">Name</label>
                            <input type="text" class="form-control @error('product_name') is-invalid @enderror"

                            value = @if(empty(old('product_name')))
                                            "{{ $product->product_name }}"
                                    @else
                                            "{{ old('product_name') }}"
                                    @endif

                            id="product_name" name="product_name"
                                aria-describedby="product_nameHelp">
                            @error('product_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                    </div>

                    <div class="mb-3 p-1">
                        <label for="product_sku">SKU</label>
                        <input type="text" class="form-control @error('product_sku') is-invalid @enderror"

                        value = @if(empty(old('product_sku')))
                                        "{{ $product->product_sku }}"
                                @else
                                        "{{ old('product_sku') }}"
                                @endif

                            id="product_sku" name="product_sku"
                            aria-describedby="product_skuHelp">
                        @error('product_sku')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 p-1">
                        <label for="product_type">Type</label>
                        <select class="form-select @error('product_type') is-invalid @enderror" id="product_type"
                            name="product_type" aria-label="Product type">

                            <option value="single" {{ $product->gender == 'single' ? 'selected' : '' }}>Single</option>
                            <option value="bundle" {{ $product->gender == 'bundle' ? 'selected' : '' }}>Bundle</option>

                        </select>
                        @error('product_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3 p-1">
                        <label for="brand_id">Brand</label>
                        <select class="form-select @error('brand_id') is-invalid @enderror" id="brand_id" name="brand_id"
                            aria-label="Default select example">
                            <option value="0">Select brand</option>
                            @foreach ($brands as $item)
                                <option {{ ($item->id == $product->brand_id ? "selected": "") }}
                                    value="{{ $item->id }}">{{$item->brand_name}}</option>
                            @endforeach
                        </select>
                        @error('brand_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 p-1">
                        <label for="category_id">Category</label>
                        <input type="hidden" name="category_id_selected" id="category_id_selected" value="{{ $product->category_id }}">
                        <select class="form-select @error('category_id') is-invalid @enderror" id="category_id"
                            name="category_id" aria-label="Default select example">
                            <option value="0">Please select brand first</option>
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>


                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    Status
                </div>
                <div class="card-body">
                    <div class="mb-3 p-1">
                        <label for="product_status">Order Status</label>
                        <select class="form-select @error('product_status') is-invalid @enderror" id="product_status"
                            name="product_status" aria-label="Default select example">
                            <option value="ready" selected>Ready</option>
                            <option value="po">Pre Order</option>
                        </select>
                        @error('product_status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 p-1">
                        <label for="product_availability">Availability</label>
                        <select class="form-select @error('product_availability') is-invalid @enderror"
                            id="product_availability" name="product_availability" aria-label="Default select example">
                            <option value="y" selected>Available</option>
                            <option value="n">Not Available</option>
                        </select>
                        @error('product_availability')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="card text-center mt-4">
                <div class="card-body ">
                    <h5 class="card-title">Manage Options</h5>
                    <div class="btn-group-vertical d-block">
                        <a href="{{ route('product.color', ['product' => $product])}}" class="btn btn-outline-primary ">
                            Color Options
                        </a>
                        <a href="#" class="btn btn-outline-primary ">
                            Images
                        </a>
                        <a href="{{ route('product.variant', ['product' => $product])}}" class="btn btn-outline-primary ">
                            Variant & Price
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-lg-8 mb-4">
            <div class="card border-0 shadow components-section">
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-12">

                            <div class="mb-3 p-1">
                                <label for="product_desc">Product Desc</label>
                                <textarea class="form-control" name="product_desc" id="product_desc"> {{ $product->product_desc }}</textarea>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-4 mb-4">
            <div class="card border-0 shadow components-section">
                <div class="card-header">
                    Comments
                </div>
                <div class="card-body">

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
                            href="{{ route('product.index') }}">Back</a>
                        &nbsp;
                        <button class="btn btn-sm btn-primary" type="submit" id="button-save">Save</button>
                        <a href="#" class="btn btn-outline-danger border-0 float-end">
                            Delete product
                        </a>
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
