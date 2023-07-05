<div class="tab-pane fade show active" id="tab-desc" role="tabpanel" aria-labelledby="tab-desc-tab">
    <div class="row mb-4">
        <div class="col-lg-4 col-sm-6">
                <div class="mb-3 p-1">
                    <label for="product_sku">SKU</label>
                    <input type="text" class="form-control bg-white text-dark @error('product_sku') is-invalid @enderror"
                        value="{{ $product->product_sku }}" id="product_sku" name="product_sku" readonly
                        aria-describedby="product_skuHelp">
                    @error('product_sku')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 p-1">
                    <label for="product_type">Type</label>
                    <input type="text" class="form-control bg-white text-dark" name="" id="" value="{{ ucwords($product->product_type) }}" readonly>
                </div>
                <div class="mb-3 p-1">
                    <label for="brand_id">Brand</label>
                    <input type="text" class="form-control bg-white text-dark" name="" id="" value="{{ ucwords($product->brand_name) }}" readonly>
                </div>
                <div class="mb-3 p-1">
                    <label for="category_id">Category</label>
                    <input type="text" class="form-control bg-white text-dark" name="" id="" value="{{ ucwords($product->category_name) }}" readonly>
                </div>

                <div class="mb-3 p-1">
                    <label for="product_status">Status</label>
                    <input type="text" class="form-control bg-white text-dark" name="" id="" value="{{ ucwords($product->product_status) }}" readonly>
                </div>

                <div class="mb-3 p-1">
                    <label for="product_availability">Availability</label>
                    <input type="text" class="form-control bg-white text-dark" name="" id="" value="{{ ($product->product_availability == 'y') ? 'Available' : 'Not Available' }}" readonly>
                </div>
        </div>
        <div class="col-lg-8 col-sm-6">

            <div class="mb-3 p-1">
                <label for="product_desc">Product Desc</label>
                <hr>
                {!! $product->product_desc !!}
                <hr>
            </div>

            <div class="mb-0 p-1 d-flex justify-content-end">
                <a class="btn btn-sm btn-gray-100 float-end" type="button" id="button-back"
                    href="{{ route('product.index') }}">Back</a>
            </div>

        </div>
    </div>
</div>
