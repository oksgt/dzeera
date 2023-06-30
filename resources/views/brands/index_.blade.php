@extends('layouts.app')

@section('content')
    <div class="main py-4">
        <div class="card card-body border-0 shadow table-wrapper table-responsive">
            <h2 class="mb-4 h5">{{ __('Brands') }}</h2>

            <p class="text-info mb-0">List Brands</p>

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
                                <button type="button" class="btn btn-sm btn-primary d-inline-flex align-items-center">
                                    Edit
                                </button>
                                <button type="button" class="btn btn-sm btn-secondary d-inline-flex align-items-center">
                                    Delete
                                </button>
                            </td>
                        </tr>
                        <?php $no++; ?>
                    @endforeach
                </tbody>
            </table>
            <div
                class="card-footer px-3 border-0 d-flex flex-column flex-lg-row align-items-center justify-content-between">
                {{ $brands->links() }}
            </div>
        </div>
    </div>
@endsection
