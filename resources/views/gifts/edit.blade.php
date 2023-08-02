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
                    <li class="breadcrumb-item"><a href="{{ route('gifts.index') }}">Gifts</a></li>
                    <li class="breadcrumb-item"><a href="#">Edit</a></li>
                </ol>
            </nav>
            <h2 class="h4">Edit Gift</h2>
            <p class="mb-0">Gift data form</p>
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
                        <div class="col-lg-6 col-sm-6">
                            <!-- Form -->
                            <form action="{{ route('gifts.update', ['gift' => $gift]) }}" method="post">
                                @csrf
                                @method('post')
                                <div class="mb-0 p-1">
                                    <label for="gift_name">Gift Name</label>
                                    <input type="text" class="form-control @error('gift_name') is-invalid @enderror"
                                        value=@if (empty(old('gift_name'))) "{{ $gift->gift_name }}"
                                        @else
                                            "{{ old('gift_name') }}" @endif
                                        id="gift_name" name="gift_name" aria-describedby="gift_nameHelp">
                                    @error('gift_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-0 p-1">
                                    <label for="product_id">Product</label>
                                    <select class="form-select @error('product_id') is-invalid @enderror" id="product_id"
                                        name="product_id" aria-label="Default select example">
                                        <option value="">--Please Choose--</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}"
                                                {{ $gift->product_id == $product->id ? 'selected' : '' }}>
                                                {{ $product->product_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-0 p-1">
                                    <label for="product_opt_id">Product Variant</label>
                                    <select class="form-select @error('product_opt_id') is-invalid @enderror"
                                        id="product_opt_id" name="product_opt_id" aria-label="Default select example">
                                        <option value="">Select an option</option>
                                    </select>
                                </div>
                                <div class="mb-0 p-1">
                                    <label for="gift_description">Gift Desc</label>
                                    <input type="text"
                                        class="form-control @error('gift_description') is-invalid @enderror"
                                        value=@if (empty(old('gift_description'))) "{{ $gift->gift_description }}"
                                        @else
                                            "{{ old('gift_description') }}" @endif
                                        id="gift_description" name="gift_description"
                                        aria-describedby="gift_descriptionHelp">
                                    @error('gift_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- </form> --}}
                                <!-- End of Form -->
                        </div>
                        <div class="col-lg-6 col-sm-6">

                            <div class="mb-0 p-1">
                                <label for="is_for_first_purchase">Is For First Purchase</label>
                                <select class="form-select @error('is_for_first_purchase') is-invalid @enderror"
                                    id="is_for_first_purchase" name="is_for_first_purchase"
                                    aria-label="Default select example">
                                    <option value="y" {{ $gift->is_for_first_purchase == 'y' ? 'selected' : '' }}>Yes
                                    </option>
                                    <option value="n" {{ $gift->is_for_first_purchase == 'n' ? 'selected' : '' }}>No
                                    </option>
                                </select>
                                @error('is_for_first_purchase')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-0 p-1">
                                <label for="min_purchase_value">Min Purchase Value</label>
                                <input type="text"
                                    class="form-control input-number-only @error('min_purchase_value') is-invalid @enderror"
                                    value=@if (empty(old('min_purchase_value'))) "{{ $gift->min_purchase_value }}"
                                        @else
                                            "{{ old('min_purchase_value') }}" @endif
                                    id="min_purchase_value" name="min_purchase_value" aria-describedby="valueHelp">
                                @error('min_purchase_value')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-0 p-1">
                                <label for="is_active">Status</label>
                                <select class="form-select @error('is_active') is-invalid @enderror" id="is_active"
                                    name="is_active" aria-label="Default select example">
                                    <option value="y" {{ $gift->is_active == 'y' ? 'selected' : '' }}>Available
                                    </option>
                                    <option value="n" {{ $gift->is_active == 'n' ? 'selected' : '' }}>Not Available
                                    </option>
                                </select>
                                @error('is_active')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
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
                        <button class="btn btn-sm btn-primary" type="submit" id="button-save">Update</button>
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
            let input_value = $('#min_purchase_value').val();
            let cleaned_value = input_value.replace('.00', '');
            $('#min_purchase_value').val(formatCurrency(cleaned_value));

            $.ajax({
                url: '{{ route('gifts.getProductOptions', '') }}/' + {{$gift->product_id }},
                type: 'GET',
                dataType: 'json',
                success: function(options) {
                    $('#product_opt_id').empty();
                    $.each(options, function(key, value) {

                        let selected = ({{$gift->product_opt_id }} == value.id) ? "selected" : "";
                        // console.log(selected);
                        $('#product_opt_id').append('<option value="' + value.id + '" '+selected+'>' + value
                            .color_name + ' size ' + value.size + '</option>');
                    });
                }
            });

            var dateInput = $('.input_date');
            dateInput.datepicker({
                format: 'dd-mm-yyyy',
                autoclose: true,
                todayHighlight: true
            });

            $('.input-number-only').keyup(function(event) {
                if (event.which >= 37 && event.which <= 40) return;
                $(this).val(function(index, value) {
                    return value
                        .replace(/\D/g, "")
                        .replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                });
            });

            function formatCurrency(value) {
                return value
                    .replace(/\D/g, "")
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }

            $('#product_id').on('change', function() {
                var productId = $(this).val();
                if (productId) {
                    $.ajax({
                        url: '{{ route('gifts.getProductOptions', '') }}/' + productId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(options) {
                            $('#product_opt_id').empty();
                            $.each(options, function(key, value) {
                                $('#product_opt_id').append('<option value="' + value
                                    .id + '">' + value.color_name + ' size ' + value
                                    .size + '</option>');
                            });
                        }
                    });
                } else {
                    $('#product_opt_id').empty();
                    $('#product_opt_id').append('<option value="">Select an option</option>');
                }
            });

        });
    </script>
@endpush
@stack('scripts')
