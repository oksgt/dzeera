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
                    <li class="breadcrumb-item"><a
                            href="{{ route('product.variant', ['product' => $product]) }}">Variant</a>
                    </li>
                    <li class="breadcrumb-item"><a
                        href="#">Add Variant</a>
                </li>
                </ol>
            </nav>
            <h2 class="h4">Add Product Variant</h2>
            <p class="mb-0" style="font-weight: 500">{{ $product->brand_name }} > {{ $product->category_name }} >
                {{ $product->product_name }}</p>
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
        <div class="col-md-6 col-lg-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('product.variant.save', ['product' => $product->id]) }}" method="post">
                        @csrf
                        @method('POST')

                        <div class="mb-3 p-1">
                            <label for="color">Color</label>
                            <select class="form-select @error('color') is-invalid @enderror" id="color"
                                name="color" aria-label="Default select example">
                                <option value="0">Select Size</option>
                                @foreach ($ProductColorOption as $item)
                                    <option
                                    {{ ($item->id == old('color')) ? 'selected' : '' }}
                                        value="{{ $item->id }}">{{ $item->color_name }}</option>
                                @endforeach
                            </select>
                            @error('color')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 p-1">
                            <label for="size_opt_id">Size</label>
                            <select class="form-select @error('size_opt_id') is-invalid @enderror" id="size_opt_id"
                                name="size_opt_id" aria-label="Default select example">
                                <option value="0">Select Size</option>
                                @foreach ($ProductSizeOption as $item)
                                    <option
                                    {{ ($item->id == old('size_opt_id'))  ? 'selected' : '' }}
                                        value="{{ $item->id }}">{{ $item->size }}</option>
                                @endforeach
                            </select>
                            @error('size_opt_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 p-1">
                            <label for="stock">Stock</label>
                            <input type="text" class="form-control input-number-only @error('stock') is-invalid @enderror"
                                value=@if (empty(old('stock'))) "{{ $product->stock }}"
                                    @else
                                            "{{ old('stock') }}" @endif
                                id="stock" name="stock" aria-describedby="stockHelp">
                            @error('stock')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 p-1">
                            <label for="weight">Weight</label>
                            <input type="text" class="form-control input-number-only @error('weight') is-invalid @enderror"
                                value=@if (empty(old('weight'))) "{{ $product->weight }}"
                                @else
                                        "{{ old('weight') }}" @endif
                                id="weight" name="weight" aria-describedby="weightHelp">
                            @error('weight')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-6 mb-4">
            <div class="card">
                <div class="card-body">

                        <div class="mb-3 p-1">
                            <label for="base_price">Base Price</label>
                            <input type="text" class="form-control input-number-only @error('base_price') is-invalid @enderror"
                                value=@if (empty(old('base_price'))) "{{ $product->base_price }}"
                                @else
                                        "{{ old('base_price') }}" @endif
                                id="base_price" name="base_price" aria-describedby="base_priceHelp">
                            @error('base_price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 p-1">
                            <label for="disc">Disc (%)</label>
                            <input type="text" class="form-control input-number-only @error('disc') is-invalid @enderror"
                                value=@if (empty(old('disc'))) "{{ $product->disc }}"
                                @else
                                        "{{ old('disc') }}" @endif
                                id="disc" name="disc" aria-describedby="discHelp">
                            @error('disc')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 p-1">
                            <label for="price">Price</label>
                            <input type="text" class="form-control input-number-only @error('price') is-invalid @enderror" readonly
                                value=@if (empty(old('price'))) "{{ $product->price }}"
                                @else
                                        "{{ old('price') }}" @endif
                                id="price" name="price" aria-describedby="priceHelp">
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 p-1">
                            <label for="option_availability">Availability</label>
                            <select class="form-select @error('option_availability') is-invalid @enderror"
                                id="option_availability" name="option_availability" aria-label="Default select example">
                                <option value="y" selected>Available</option>
                                <option value="n">Not Available</option>
                            </select>
                            @error('option_availability')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-center">
                        <a class="btn btn-sm btn-gray-100 " type="button" id="button-back"
                            href="{{ url()->previous() }}">Back</a>
                        &nbsp;
                        <button class="btn btn-sm btn-primary" type="submit" id="button-save">Save</button>
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
            $('.input-number-only').on('input', function() {
                $(this).val($(this).val().replace(/[^0-9]/g, ''));
            });

            $('.input-number-only').keyup(function(event) {
                // skip for arrow keys
                if(event.which >= 37 && event.which <= 40) return;

                // format number
                $(this).val(function(index, value) {
                    return value
                    .replace(/\D/g, "")
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ".")
                    ;
                });
            });

            $("#base_price, #disc").keyup(function() {
                var basePrice = parseFloat($("#base_price").val().replace(/\./g, ''));
                var disc = parseFloat($("#disc").val().replace(/\./g, ''));
                var price = basePrice - ( basePrice * (disc / 100) );

                $("#price").val(price);

                $("#price").val(function(index, value) {
                    return value
                    .replace(/\D/g, "")
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ".")
                    ;
                });
            });
        });


    </script>
@endpush
@stack('scripts')
