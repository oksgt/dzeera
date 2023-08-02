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
                    <li class="breadcrumb-item"><a href="{{ route('bank-accounts.index') }}">Bank Accounts</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('bank-accounts.create') }}">Create</a></li>
                </ol>
            </nav>
            <h2 class="h4">Edit Bank Account</h2>
            <p class="mb-0">Bank Account data form</p>
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
                            <form action="{{ route('bank-accounts.update', ['bankAccount' => $bankAccount]) }}" method="post">
                                @csrf
                                @method('post')
                                <div class="mb-0 p-1">
                                    <label for="bank_name">Bank Name</label>
                                    <input type="text" class="form-control @error('bank_name') is-invalid @enderror"
                                    value=
                                        @if(empty(old('bank_name')))
                                            "{{ $bankAccount->bank_name }}"
                                        @else
                                            "{{ old('bank_name') }}"
                                        @endif

                                    id="bank_name" name="bank_name" aria-describedby="brandNameHelp">
                                    @error('bank_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-0 p-1">
                                    <label for="account_name">Account Name</label>
                                    <input type="text" class="form-control @error('account_name') is-invalid @enderror"
                                    value=
                                        @if(empty(old('account_name')))
                                            "{{ $bankAccount->account_name }}"
                                        @else
                                            "{{ old('account_name') }}"
                                        @endif

                                    id="account_name" name="account_name" aria-describedby="brandNameHelp">
                                    @error('account_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-0 p-1">
                                    <label for="account_number">Account Number</label>
                                    <input type="text" class="form-control @error('account_number') is-invalid @enderror"
                                    value=
                                        @if(empty(old('account_number')))
                                            "{{ $bankAccount->account_number }}"
                                        @else
                                            "{{ old('account_number') }}"
                                        @endif

                                    id="account_number" name="account_number" aria-describedby="brandNameHelp">
                                    @error('account_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 p-1">
                                    <label for="option_availability">Status</label>
                                    <select class="form-select @error('is_active') is-invalid @enderror"
                                        id="is_active" name="is_active" aria-label="Default select example">
                                        <option value="y" {{ $bankAccount->is_active == 'y' ? 'selected' : '' }}>Available</option>
                                        <option value="n" {{ $bankAccount->is_active == 'n' ? 'selected' : '' }}>Not Available</option>
                                    </select>
                                    @error('is_active')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-0 p-1 d-flex justify-content-between">
                                    <a class="btn btn-sm btn-gray-100 float-start" type="button" id="button-back" href="{{ url()->previous() }}">Back</a>

                                    <button class="btn btn-sm btn-primary float-end" type="submit" id="button-save">Update</button>
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
