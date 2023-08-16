@extends('layouts.app')
<style>
.price-tag {
  width: auto !important;
  margin-left: 16px;
    margin-top: 16px !important;
  display: flex;
  align-items: center;
  background-color: #f2f2f2;
  /* padding: 1px; */
  border-radius: 4px;
  width: fit-content;
  position: relative;
}

.triangle {
  width: 0;
  height: 0;
  border-top: 7px solid transparent;
  border-right: 7px solid #f2f2f2;
  border-bottom: 7px solid transparent;
  position: absolute;
  left: -7px;
}

.price {
  font-weight: normal;
  color: #555555;
  margin: 0 8px;
  font-size: 13px !important;
}

.close-button {
  border: none;
  background-color: transparent;
  color: #999999;
  font-size: 16px;
  cursor: pointer;
}
</style>
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
                    <li class="breadcrumb-item"><a href="{{ route('product.index') }}">Products</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('product.detail', ['product' => $product]) }}">Detail</a>
                    <li class="breadcrumb-item"><a href="{{ route('product.images', ['product' => $product]) }}">Tags</a>
                    </li>
                </ol>
            </nav>
            <h2 class="h4">Product Tags</h2>
            <p class="mb-0" style="font-weight: 500">{{ $product->brand_name }} > {{ $product->category_name }} >
                {{ $product->product_name }}</p>
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

    <div class="card card-body border-0 shadow table-wrapper ">

        <div class="col-3 mb-0">
            <form action="{{route('product.tag.add')}}" method="post" enctype="multipart/form-data">
                @csrf
                @method('post')
                <input type="hidden" name="product_id" id="product_id" value="{{ $product->id }}">
                <div class="mb-3">
                    <label for="tag_id">Tag</label>
                    <div class="input-group">
                        <select class="form-select @error('tag_id') is-invalid @enderror" id="tag_id" name="tag_id"
                            aria-label="Default select example">
                            <option value="default">Choose Tag</option>
                            @foreach ($available_tag as $tag)
                                <option value="{{ $tag->id }}">{{ $tag->tag_name }}</option>
                            @endforeach
                        </select>
                        <button class="btn btn-primary" type="submit">Add</button>
                    </div>
                    @error('tag_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </form>


        </div>

        <div class="row">

            @foreach ($product_tag as $item)
                <div class="price-tag">
                    <span class="triangle"></span>
                    <span class="price">{{$item->tag_name}}</span>
                    <form action="{{route('product.tag.remove')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('post')
                        <input type="hidden" name="id" id="id" value="{{ $item->id }}">
                        <input type="hidden" name="product_id" id="product_id" value="{{ $product->id }}">
                        <button type="submit" class="close-button">×</button>
                    </form>
                </div>
            @endforeach

        </div>


        <div class="card-footer px-3 border-0 d-flex flex-column flex-lg-row align-items-center justify-content-start">
            <div class="mb-0 p-1 d-flex justify-content-between">
                <a class="btn btn-sm btn-gray-100 float-end" type="button" id="button-back"
                    href="{{ route('product.detail', ['product' => $product]) }}">
                    Back</a>
            </div>
        </div>
    </div>
@endsection

{{-- @push('scripts') --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        function set_thumbnail(imageId) {
            $.ajax({
                url: '{{ url('product/images/setThumbnail') }}',
                type: 'POST',
                data: {
                    image_id: imageId
                },
                success: function(response) {
                    console.log(response.message);
                    // Do something on success, such as updating the UI or reloading the page
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    // Do something on error, such as displaying an error message
                }
            });
        }
    });
</script>
{{-- @endpush
@stack('scripts') --}}
