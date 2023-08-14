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
                    <div class="mb-0 p-1">

                        <form action="{{ route('product.update', ['product' => $product->id]) }}" method="post">
                            @csrf
                            @method('POST')
                            <label for="product_name">Name</label>
                            <input type="text" class="form-control @error('product_name') is-invalid @enderror"
                                value=@if (empty(old('product_name'))) "{{ $product->product_name }}"
                                    @else
                                            "{{ old('product_name') }}" @endif
                                id="product_name" name="product_name" aria-describedby="product_nameHelp">
                            @error('product_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                    </div>

                    <div class="mb-3 p-1">
                        <label for="product_sku">SKU</label>
                        <input type="text" class="form-control @error('product_sku') is-invalid @enderror"
                            value=@if (empty(old('product_sku'))) "{{ $product->product_sku }}"
                                @else
                                        "{{ old('product_sku') }}" @endif
                            id="product_sku" name="product_sku" aria-describedby="product_skuHelp">
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
                                <option {{ $item->id == $product->brand_id ? 'selected' : '' }}
                                    value="{{ $item->id }}">{{ $item->brand_name }}</option>
                            @endforeach
                        </select>
                        @error('brand_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 p-1">
                        <label for="category_id">Category</label>
                        <input type="hidden" name="category_id_selected" id="category_id_selected"
                            value="{{ $product->category_id }}">
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
                <div class="card-body">
                    <div class="mb-3 p-1">
                        <label for="rating">Rating</label>
                        <select class="form-select @error('rating') is-invalid @enderror" id="rating"
                            name="rating" aria-label="Default select example">
                            <option value="0" {{ $product->rating == '0' ? 'selected' : '' }}>0</option>
                            <option value="1" {{ $product->rating == '1' ? 'selected' : '' }}>1</option>
                            <option value="1.5" {{ $product->rating == '1,5' ? 'selected' : '' }}>1.5</option>
                            <option value="2" {{ $product->rating == '2' ? 'selected' : '' }}>2</option>
                            <option value="2.5" {{ $product->rating == '2.5' ? 'selected' : '' }}>2.5</option>
                            <option value="3" {{ $product->rating == '3' ? 'selected' : '' }}>3</option>
                            <option value="3.5" {{ $product->rating == '3.5' ? 'selected' : '' }}>3.5</option>
                            <option value="4" {{ $product->rating == '4' ? 'selected' : '' }}>4</option>
                            <option value="4.5" {{ $product->rating == '4.5' ? 'selected' : '' }}>4.5</option>
                            <option value="5" {{ $product->rating == '5' ? 'selected' : '' }}>5</option>
                        </select>
                        @error('rating')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 p-1">
                        <label for="product_status">Order Status</label>
                        <select class="form-select @error('product_status') is-invalid @enderror" id="product_status"
                            name="product_status" aria-label="Default select example">
                            <option value="ready" {{ $product->product_status == 'ready' ? 'selected' : '' }}>Ready</option>
                            <option value="po" {{ $product->product_status == 'po' ? 'selected' : '' }}>Pre Order</option>
                        </select>
                        @error('product_status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 p-1">
                        <label for="product_availability">Availability</label>
                        <select class="form-select @error('product_availability') is-invalid @enderror"
                            id="product_availability" name="product_availability" aria-label="Default select example">
                            <option value="y"  {{ $product->product_availability == 'y' ? 'selected' : '' }}>Available</option>
                            <option value="n"  {{ $product->product_availability == 'n' ? 'selected' : '' }}>Not Available</option>
                        </select>
                        @error('product_availability')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 p-1">
                        <label for="highlight">Highlight</label>
                        <select class="form-select @error('highlight') is-invalid @enderror"
                            id="highlight" name="highlight" aria-label="Default select example">
                            <option value="y" {{ $product->highlight == 'y' ? 'selected' : '' }}>Yes</option>
                            <option value="n" {{ $product->highlight == 'n' ? 'selected' : '' }}>No</option>
                        </select>
                        @error('highlight')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 p-1">
                        <label for="highlight">Tags</label>

                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-lg-8 mt-4">
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
        <div class="col-md-12 col-lg-4 ">
            <div class="card text-center mt-4">
                <div class="card-body ">
                    <h5 class="card-title">Manage Options</h5>
                    <div class="btn-group-vertical d-block">
                        <a href="{{ route('product.options', ['product' => $product]) }}"
                            class="btn btn-outline-primary ">
                            Color & Size Options
                        </a>
                        <a href="{{ route('product.images', ['product' => $product]) }}"
                            class="btn btn-outline-primary ">
                            Images
                        </a>
                        <a href="{{ route('product.variant', ['product' => $product]) }}"
                            class="btn btn-outline-primary ">
                            Variant & Price
                        </a>
                        <a href="{{ route('product.tags', ['product' => $product]) }}"
                            class="btn btn-outline-primary ">
                            Tags
                        </a>
                    </div>
                </div>

            </div>
            <div class="card border-0 shadow components-section mt-4">
                <div class="card-header">
                    Image Thumbnail
                </div>
                <div class="card-body ">
                    <div class="card border-0" >

                        @if ($product_image)
                            <div style="height: 200px; overflow: hidden; display: flex; align-items: center; justify-content: center;">
                                <img src="<?= asset('storage/img_product/'.$product_image->file_name) ?>" class="card-img-top"
                                style="max-height: 100%; max-width: 100%; object-fit: contain;">
                            </div>
                        @else
                            <div style="height: 200px; overflow: hidden; display: flex; align-items: center; justify-content: center;">
                                <img src="<?= asset('images/no-image.png') ?>" class="card-img-top"
                                style="max-height: 100%; max-width: 100%; object-fit: contain;">
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 mt-4">
            <div class="card">
                <div class="card-body">
                    <div class="justify-content-start">
                        <a class="btn btn-sm btn-gray-100 " type="button" id="button-back"
                            href="{{ route('product.index') }}">Back</a>
                        &nbsp;
                        <button class="btn btn-sm btn-primary" type="submit" id="button-save">Update</button>
                        <a href="{{ route('product.delete', ['product' => $product]) }}"
                            class="btn btn-outline-danger border-0 float-end">
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {

            var brand_id = $('#brand_id').val();
            if (brand_id > 0) {
                $.ajax({
                    url: "{{ url('category/list') }}/" + brand_id,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#category_id').empty();
                        $.each(data, function(key, value) {
                            var selected = "";
                            if({{ $product->category_id }} == value.id){
                                selected = "selected";
                            } else {
                                selected = "";
                            }
                            $('#category_id').append('<option '+selected+' value="' + value.id + '">' +
                                value.category_name + '</option>');
                        });
                    }
                });
            } else {
                $('#category_id').empty();
                $('#category_id').append('<option value="">Please select brand first</option>');
            }

            $('#brand_id').on('change', function() {
                var brand_id = $(this).val();
                if (brand_id > 0) {
                    $.ajax({
                        url: "{{ url('category/list') }}/" + brand_id,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#category_id').empty();
                            $.each(data, function(key, value) {
                                $('#category_id').append('<option value="' + value.id +
                                    '">' +
                                    value.category_name + '</option>');
                            });
                        }
                    });
                } else {
                    $('#category_id').empty();
                    $('#category_id').append('<option value="">Please select brand first</option>');
                }
            });

        });
    </script>
@endpush
@stack('scripts')
