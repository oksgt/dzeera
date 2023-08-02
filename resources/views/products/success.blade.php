@extends('layouts.app')

@section('content')

    <div class="card card-body border-0 shadow table-wrapper ">
        <div class="card-header border-0 d-flex flex-column flex-lg-row align-items-center justify-content-start p-0">
            <div class="mb-0">
            </div>
        </div>
        <div class="card-body table-responsive d-flex justify-content-center align-items-center">
            <div class="card text-center border-0" style="width: 20rem;" >
                <img class="card-img-top" src="{{ asset('images/done.svg') }}" alt="Success Purchase" width="300px">
                <div class="card-body">
                    <h5 class="card-title text-success">Success add product</h5>
                    <h5 class="card-title">"{{ $product->product_name }}"</h5>
                </div>
                <div class="card-footer d-flex justify-content-center">
                    <a href="{{ url()->previous() }}" class="btn btn-gray-100 float-start">Back</a>
                </div>
              </div>
        </div>
    </div>
@endsection

