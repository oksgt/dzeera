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
                    <li class="breadcrumb-item"><a href="{{ route('product.detail', ['product' => $product->id]) }}">Detail</a></li>
                </ol>
            </nav>
            <h2 class="h4">Product "{{ $product->product_name }}"</h2>
            <p class="mb-0">Brand "{{ $product->brand_name }}" > Category "{{ $product->category_name }}"</p>
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

    <div class="row">
        <div class="col-12 mb-0">
            <div class="card border-0 shadow components-section">
                <div class="card-body">
                    <!-- Tab Nav -->
                    <div class="nav-wrapper position-relative mb-2">
                        <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="tabs-text" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link mb-sm-3 mb-md-0 active" id="tabs-text-1-tab"
                                data-bs-toggle="tab" href="#tab-desc" role="tab" aria-controls="tab-desc" aria-selected="true">Desc</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mb-sm-3 mb-md-0" id="tabs-text-2-tab"
                                data-bs-toggle="tab" href="#option-tab" role="tab" aria-controls="option-tab" aria-selected="false">Options</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mb-sm-3 mb-md-0" id="tabs-text-3-tab"
                                data-bs-toggle="tab" href="#image-tab" role="tab" aria-controls="image-tab" aria-selected="false">Images</a>
                            </li>
                        </ul>
                    </div>
                    <!-- End of Tab Nav -->
                    <div class="card border-0">
                        <div class="card-body p-0">
                            <div class="tab-content" id="tabcontent1">

                                @include('products.desc')
                                @include('products.option')
                                @include('products.image')

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection



