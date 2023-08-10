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
                    <li class="breadcrumb-item"><a href="{{ route('category.index') }}">Category</a></li>
                    <li class="breadcrumb-item"><a href="#">Edit</a></li>
                </ol>
            </nav>
            <h2 class="h4">Edit Category</h2>
            <p class="mb-0">Category data form</p>
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
                            <form action="{{ route('category.update', ['category' => $category->id]) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="mb-3 p-1">
                                    <label for="brand_id">Brand Name</label>
                                    <select class="form-select @error('brand_id') is-invalid @enderror" id="brand_id" name="brand_id" aria-label="Default select example">
                                        <option value="default">Open this select menu</option>
                                        @foreach ($brands as $item)
                                            <option {{ ($item->id == $category->brand_id ? "selected": "") }} value="{{ $item->id }}">{{$item->brand_name}}</option>
                                        @endforeach
                                    </select>
                                    @error('brand_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-0 p-1">
                                    <label for="category_name">Category Name</label>
                                    <input type="text" class="form-control @error('category_name') is-invalid @enderror"
                                    value=
                                        @if(empty(old('category_name')))
                                            "{{ $category->category_name }}"
                                        @else
                                            "{{ old('category_name') }}"
                                        @endif

                                    id="category_name" name="category_name" aria-describedby="brandNameHelp">
                                    @error('category_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                </div>

                                <div class="mb-0 p-1">
                                    <label for="highlight">Highlight</label>
                                    <select class="form-select @error('highlight') is-invalid @enderror"
                                        id="highlight" name="highlight" aria-label="Default select example">
                                        <option value="y" {{ $category->highlight == 'y' ? 'selected' : '' }}>Yes</option>
                                        <option value="n" {{ $category->highlight == 'n' ? 'selected' : '' }}>No</option>
                                    </select>
                                    @error('highlight')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            <!-- End of Form -->
                        </div>
                        <div class="col-lg-4 col-sm-6">
                            <div class="mb-0 p-1">
                                <label for="brand_id">Current Image</label>
                                <div class="card" >

                                    <div style="height: 200px; overflow: hidden; display: flex; align-items: center; justify-content: center;">
                                        <img src="<?= asset('/images/category/'.$category->image) ?>" class="card-img-top"
                                        style="max-height: 100%; max-width: 100%; object-fit: contain;">
                                    </div>

                                </div>
                            </div>

                            <div class="mb-0 p-1">
                                <label for="file" class="form-label">Change Image</label>
                                <div class="input-group input-group-sm">
                                    <input type="file" class="form-control" id="file" name="file" accept="image/*">
                                </div>
                                @error('file')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-8 col-sm-6">
                            <div class="mb-0 p-1 d-flex justify-content-between">
                                <a class="btn btn-sm btn-gray-100 float-start" type="button" id="button-back" href="{{ route('category.index') }}">Back</a>

                                <button class="btn btn-sm btn-primary float-end" type="submit" id="button-save">Update</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
