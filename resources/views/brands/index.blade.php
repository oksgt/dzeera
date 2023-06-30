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
                    <li class="breadcrumb-item"><a href="{{ route('brands.index') }}">Brands</a></li>
                </ol>
            </nav>
            <h2 class="h4">Brands</h2>
            <p class="mb-0">Brand data list</p>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('brands.create') }}" class="btn btn-sm btn-gray-800 d-inline-flex align-items-center">
                <svg class="icon icon-xs me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6">
                    </path>
                </svg>
                New Brand
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

    <div class="card card-body border-0 shadow table-wrapper table-responsive">

        <table class="table table-hover">
            <thead>
                <tr>
                    <th class="border-gray-200">{{ __('No') }}</th>
                    <th class="border-gray-200">{{ __('Brand Name') }}</th>
                    <th class="border-gray-200">{{ __('Slug') }}</th>
                    <th class="border-gray-200">{{ __('#') }}</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                @foreach ($brands as $brand)
                    <tr>
                        <td><span class="fw-normal">{{ $no }}</span></td>
                        <td><span class="fw-normal">{{ $brand->brand_name }}</span></td>
                        <td><span class="fw-normal">{{ $brand->slug }}</span></td>
                        <td>
                            <a type="button" class="btn btn-sm btn-primary d-inline-flex align-items-center"
                                href="{{ route('brands.edit', ['brand' => $brand]) }}">
                                Edit
                            </a>
                            <a type="button" class="btn btn-sm btn-secondary d-inline-flex align-items-center"
                                href="{{ route('brands.delete', ['brand' => $brand]) }}">
                                Delete
                            </a>
                        </td>
                    </tr>
                    <?php $no++; ?>
                @endforeach
            </tbody>
        </table>
        <div class="card-footer px-3 border-0 d-flex flex-column flex-lg-row align-items-center justify-content-between">
            {{ $brands->links() }}
        </div>
    </div>
@endsection
