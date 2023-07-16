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
                    <li class="breadcrumb-item"><a href="{{ route('product.options', ['product' => $product]) }}">Options</a>
                    <li class="breadcrumb-item"><a href="#">Edit Color</a>
                </ol>
            </nav>
            <h2 class="h4">Edit Color Option</h2>
            <p class="mb-0">Edit color option for {{ $product->product_name }}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            @if (session()->has('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('errors') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-12 mb-4">
            <div class="card border-0 shadow components-section">
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-lg-4 col-sm-6">
                            <!-- Form -->
                            <form action="{{ route('product.color.create.update') }}" method="post">
                                @csrf
                                <input type="hidden" name="id" value="{{ $ProductColorOption->id }}">
                                <input type="hidden" name="product_id" value="{{ $ProductColorOption->product_id }}">
                                <div class="mb-0 p-1">
                                    <label for="color_name">Color Name</label>
                                    <input type="text" class="form-control @error('color_name') is-invalid @enderror"
                                    value=
                                        @if(empty(old('color_name')))
                                            "{{ $ProductColorOption->color_name }}"
                                        @else
                                            "{{ old('color_name') }}"
                                        @endif

                                    id="color_name" name="color_name" aria-describedby="brandNameHelp">
                                    @error('color_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-0 p-1 d-flex justify-content-between">
                                    <a class="btn btn-sm btn-gray-100 float-start" type="button" id="button-back" href="{{ url()->previous() }}">Back</a>

                                    <button class="btn btn-sm btn-primary float-end" type="submit" id="button-save">Save</button>
                                  </div>
                            </form>
                            <!-- End of Form -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
