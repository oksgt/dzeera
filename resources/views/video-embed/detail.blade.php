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
                    <li class="breadcrumb-item"><a href="{{ route('video-embedded.index') }}">Video Embedded</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('video-embedded.create') }}">Create</a></li>
                </ol>
            </nav>
            <h2 class="h4">Add New Video Embedded</h2>
            <p class="mb-0">Video embedded data form</p>
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
                            <form action="{{ route('video-embedded.update', ['videoEmbed' => $videoEmbed]) }}" method="post">
                                @csrf
                                <div class="mb-0 p-1">
                                    <label for="brand_id">Brand Name</label>
                                    <select class="form-select @error('brand_id') is-invalid @enderror" id="brand_id" name="brand_id" aria-label="Default select example">
                                        <option value="default">Open this select menu</option>
                                        @foreach ($brand as $item)
                                            <option {{ ($item->id == $videoEmbed->brand_id ? "selected": "") }} value="{{ $item->id }}">{{$item->brand_name}}</option>
                                        @endforeach
                                    </select>
                                    @error('brand_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-0 p-1">
                                    <label for="title">Video Title</label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                                    value=
                                        @if(empty(old('title')))
                                            "{{ $videoEmbed->title }}"
                                        @else
                                            "{{ old('title') }}"
                                        @endif
                                    id="title" name="title" aria-describedby="titleHelp">
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-0 p-1">
                                    <label for="url">Video URL</label>
                                    <input type="text" class="form-control @error('url') is-invalid @enderror"
                                    value=
                                        @if(empty(old('url')))
                                            "{{ $videoEmbed->url }}"
                                        @else
                                            "{{ old('url') }}"
                                        @endif
                                    id="url" name="url" aria-describedby="urlHelp">
                                    @error('url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-0 p-1">
                                    <label for="is_active">Active</label>
                                    <select class="form-select @error('is_active') is-invalid @enderror"
                                        id="is_active" name="is_active" aria-label="Default select example">
                                        <option value="1" {{ $videoEmbed->is_active == 1 ? 'selected' : '' }}>Yes</option>
                                        <option value="0" {{ $videoEmbed->is_active == 0 ? 'selected' : '' }}>No</option>
                                    </select>
                                    @error('is_active')
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
