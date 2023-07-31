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
                    <li class="breadcrumb-item"><a href="{{ route('vouchers.index') }}">Vouchers</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('vouchers.create') }}">Create</a></li>
                </ol>
            </nav>
            <h2 class="h4">Edit Voucher</h2>
            <p class="mb-0">Voucher data form</p>
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
                            <form action="{{ route('vouchers.update', ['voucher' => $voucher]) }}" method="post">
                                @csrf
                                @method('post')
                                <div class="mb-0 p-1">
                                    <label for="voucher_name">Voucher Name</label>
                                    <input type="text" class="form-control @error('voucher_name') is-invalid @enderror"
                                    value=
                                        @if(empty(old('voucher_name')))
                                            "{{ $voucher->voucher_name }}"
                                        @else
                                            "{{ old('voucher_name') }}"
                                        @endif

                                    id="voucher_name" name="voucher_name" aria-describedby="brandNameHelp">
                                    @error('voucher_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-0 p-1">
                                    <label for="code">Code</label>
                                    <input type="text" class="form-control @error('code') is-invalid @enderror"
                                    value=
                                        @if(empty(old('code')))
                                            "{{ $voucher->code }}"
                                        @else
                                            "{{ old('code') }}"
                                        @endif

                                    id="code" name="code" aria-describedby="brandNameHelp">
                                    @error('code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-0 p-1">
                                    <label for="start_date">Start Date</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <svg class="icon icon-xs text-gray-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd">
                                                    </path>
                                            </svg>
                                        </span>
                                        <input type="text" class="form-control input_date @error('start_date') is-invalid @enderror"
                                        value=
                                        @if(empty(old('start_date')))
                                            "{{ $voucher->start_date }}"
                                        @else
                                            "{{ old('start_date') }}"
                                        @endif
                                        id="start_date" name="start_date" aria-describedby="start_dateHelp">
                                        @error('start_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-0 p-1">
                                    <label for="end_date">End Date</label>

                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <svg class="icon icon-xs text-gray-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd">
                                                    </path>
                                            </svg>
                                        </span>
                                        <input type="text" class="form-control input_date @error('end_date') is-invalid @enderror"
                                        value=
                                        @if(empty(old('end_date')))
                                            "{{ $voucher->end_date }}"
                                        @else
                                            "{{ old('end_date') }}"
                                        @endif
                                        id="end_date" name="end_date" aria-describedby="end_dateHelp">
                                        @error('end_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            {{-- </form> --}}
                            <!-- End of Form -->
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <div class="mb-0 p-1">
                                <label for="is_percent">Is Percentage</label>
                                <select class="form-select @error('is_percent') is-invalid @enderror"
                                    id="is_percent" name="is_percent" aria-label="Default select example">
                                    <option value="y" {{ $voucher->is_active == 'y' ? 'selected' : '' }}>Yes</option>
                                    <option value="n" {{ $voucher->is_active == 'n' ? 'selected' : '' }}>No</option>
                                </select>
                                @error('is_percent')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-0 p-1">
                                <label for="value">Value</label>
                                <input type="text" class="form-control input-number-only @error('value') is-invalid @enderror"
                                value=
                                    @if(empty(old('value')))
                                        "{{ $voucher->value }}"
                                    @else
                                        "{{ old('value') }}"
                                    @endif
                                id="value" name="value" aria-describedby="valueHelp">
                                @error('value')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-0 p-1">
                                <label for="is_active">Status</label>
                                <select class="form-select @error('is_active') is-invalid @enderror"
                                    id="is_active" name="is_active" aria-label="Default select example">
                                    <option value="y" {{ $voucher->is_active == 'y' ? 'selected' : '' }}>Available</option>
                                    <option value="n" {{ $voucher->is_active == 'n' ? 'selected' : '' }}>Not Available</option>
                                </select>
                                @error('is_active')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-0 p-1">
                                <label for="voucher_desc">Voucher Desc</label>
                                <input type="text" class="form-control @error('voucher_desc') is-invalid @enderror"
                                value=
                                    @if(empty(old('voucher_desc')))
                                        "{{ $voucher->voucher_desc }}"
                                    @else
                                        "{{ old('voucher_desc') }}"
                                    @endif
                                id="voucher_desc" name="voucher_desc" aria-describedby="voucher_descHelp">
                                @error('voucher_desc')
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
                        <a class="btn btn-sm btn-gray-100 " type="button" id="button-back" href="{{ url()->previous() }}">Back</a>
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
            $('#value').val(formatCurrency($('#value').val()));

            var dateInput = $('.input_date');
            dateInput.datepicker({
                format: 'dd-mm-yyyy',
                autoclose: true,
                todayHighlight: true
            });

            $('.input-number-only').keyup(function(event) {
                if(event.which >= 37 && event.which <= 40) return;
                $(this).val(function(index, value) {
                    return value
                    .replace(/\D/g, "")
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ".")
                    ;
                });
            });

            function formatCurrency(value) {
                return value
                    .replace(/\D/g, "")
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ".")
                    ;
            }

        });
    </script>
@endpush
@stack('scripts')
