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
                    <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">Orders Detail</a></li>
                </ol>
            </nav>
            <h2 class="h4">Order Code: {{ $transaction->trans_number }}</h2>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            {{-- <a href="{{ route('orders.create') }}" class="btn btn-sm btn-gray-800 d-inline-flex align-items-center">
                <svg class="icon icon-xs me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6">
                    </path>
                </svg>
                New Social Media
            </a> --}}
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

    <div class="card card-body border-0 shadow">
        <div class="row mb-3 d-flex justify-content-center">

            @php

                $currentDateTime = new DateTime(); // Get the current date and time
                $givenDateTime = new DateTime($transaction->max_time); // Convert the given time string to a DateTime object

            @endphp

            @if ($transaction->payment_method == 'Bank Transfer')


                @if ($givenDateTime < $currentDateTime && $transaction->trans_status != 'paid')

                    <div class="col-2 col-offset-5">
                        <div class="alert alert-{{ $transaction->trans_status == 'paid' ? 'success' : 'danger' }} text-center">Cancelled</div>
                    </div>

                @else
                    <div class="col-2 col-offset-5">
                        <div class="alert alert-{{ $transaction->trans_status == 'paid' ? 'success' : 'warning' }} text-center">{{ ucwords($transaction->trans_status) }}</div>
                    </div>
                @endif

            @else
                <div class="col-2 col-offset-5">
                    <div class="alert alert-{{ $transaction->trans_status == 'paid' ? 'success' : 'warning' }} text-center">{{ ucwords($transaction->trans_status) }}</div>
                </div>
            @endif


        </div>
        <div class="row mb-4">


            <div class="col">
                <div class="card">
                    <div class="card-header">Customer Information</div>
                    <div class="card-body">
                        <table class="table table-sm small text-muted">
                            <tr>
                                <td>{{ __('general.name') }}</td>
                                <td>
                                    <input type="text" id="_cust_name" name="_cust_name" class="form-control"readonly
                                        value="{{ $transaction->cust_name }}" style="background-color: white !important">
                                </td>
                            </tr>
                            <tr>
                                <td>{{ __('general.email_address') }}</td>
                                <td>
                                    <input type="text" id="_cust_email" name="_cust_email" class="form-control" readonly
                                        value="{{ $transaction->cust_email }}" style="background-color: white !important">
                                </td>
                            </tr>
                            <tr>
                                <td>{{ __('general.phone') }}</td>
                                <td>
                                    <input type="text" id="_cust_phone" name="_cust_phone" class="form-control" readonly
                                        value="{{ $transaction->cust_phone }}" style="background-color: white !important">
                                </td>
                            </tr>
                            <tr>
                                <td>{{ __('general.address') }}</td>
                                <td>
                                    <input type="text" id="_cust_address" name="_cust_address" class="form-control"
                                        readonly value="{{ $transaction->cust_address }}" style="background-color: white !important">
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card">
                <div class="card-header">{{ __('general.shipping_information') }}</div>
                <div class="card-body">
                    <table class="table table-sm small text-muted">
                        <tr>
                            <td>{{ __('general.recipient_name') }}</td>
                            <td>
                                <input type="text" id="_recp_name" name="_recp_name" class="form-control"readonly
                                    value="{{ $transaction->recp_name }}" style="background-color: white !important">
                            </td>
                        </tr>
                        <tr>
                            <td>{{ __('general.recipient_phone') }}</td>
                            <td>
                                <input type="text" id="_recp_phone" name="_recp_phone" class="form-control"readonly
                                    value="{{ $transaction->recp_phone }}" style="background-color: white !important">
                            </td>
                        </tr>
                        <tr>
                            <td>{{ __('general.recipient_address') }}</td>
                            <td>
                                <input type="text" id="_recp_add" name="_recp_add" class="form-control"readonly
                                    value="{{ $transaction->recp_address }}" style="background-color: white !important">
                            </td>
                        </tr>
                        <tr>
                            <td>{{ __('general.province') }}</td>
                            <td>
                                <input type="text" id="_recp_prov" name="_recp_prov" class="form-control"readonly
                                    value="{{ $transaction->province }}" style="background-color: white !important">
                            </td>
                        </tr>
                        <tr>
                            <td>{{ __('general.city') }}</td>
                            <td>
                                <input type="text" id="_recp_city" name="_recp_city" class="form-control"readonly
                                    value="{{ $transaction->city }}" style="background-color: white !important">
                            </td>
                        </tr>
                        <tr>
                            <td>{{ __('general.postal_code') }}</td>
                            <td>
                                <input type="text" id="_recp_postal_code" name="_recp_postal_code" class="form-control"
                                    readonly value="{{ $transaction->cust_address }}" style="background-color: white !important">
                            </td>
                        </tr>
                        <tr>
                            <td>{{ __('general.shipping_service') }}</td>
                            <td>
                                <input type="text" id="_recp_shipping_service" name="_recp_shipping_service"
                                    class="form-control"readonly value="JNE {{ $transaction->expedition_service_type }}" style="background-color: white !important">
                                <input type="hidden" id="_service" name="_service" class="form-control"readonly>
                                <input type="hidden" id="_service_price" name="_service_price" class="form-control"
                                    readonly>
                                {{-- <input type="hidden" id="_city" name="_city" class="form-control"readonly>
                              <input type="hidden" id="_province" name="_province" class="form-control"readonly> --}}
                                <input type="hidden" id="_voucher" name="_voucher" class="form-control"readonly
                                    value="-">
                            </td>
                        </tr>

                        <tr>
                            <td>Payment Menthod</td>
                            <td>
                                <input type="text" id="_recp_postal_code" name="_recp_postal_code" class="form-control"
                                    readonly value="{{ $transaction->payment_method }}" style="background-color: white !important">
                            </td>
                        </tr>

                        <tr>
                            <td>Resi</td>
                            <td>
                                <form action="{{ route('orders.updateShippingCode', ['transactionId' => $transaction->id]) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" placeholder="Update Resi" aria-label="Update Resi" aria-describedby="button-addon2"
                                         name="shipping_code" value="{{ $transaction->shipping_code }}" >
                                        <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Update Resi</button>
                                    </div>
                                </form>
                            </td>
                        </tr>

                        <tr>
                            <td>Trans Status</td>
                            <td>
                                <form action="{{ route('orders.updateTransStatus', ['transactionId' => $transaction->id]) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="input-group mb-3">
                                        <select class="form-select" aria-label="Default select example" name="input_trans_status">
                                            @php
                                                $selected = $transaction->trans_status; // The selected option value
                                                $options = ['unpaid', 'paid']; // Array of options
                                            @endphp

                                            @foreach ($options as $option)
                                                <option value="{{ $option }}" {{ $option == $selected ? 'selected' : '' }}>
                                                    {{ ucwords($option) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Update Status</button>
                                    </div>
                                </form>
                            </td>
                        </tr>

                    </table>
                </div>
            </div>
        </div>

        <div class="card bg bg-white mt-3">
            <div class="card-body">
                <table class="table table-sm small" id="table-summary">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('general.product_name') }}</th>
                            <th>{{ __('general.quantity') }}</th>
                            <th>{{ __('general.price') }}</th>
                            <th>{{ __('general.total_price') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                                $grandTotal = 0; // Initialize grand total variable
                                foreach ($trans_detail as $index => $row):
                                    $grandTotal += $row->total_price; // Accumulate the total price for each row
                                ?>
                        <tr>
                            <td><?php echo $index + 1; ?></td>
                            <td><?php echo $row->product_name . ' - ' . $row->color_name . ' - ' . $row->size; ?></td>
                            <td><?php echo $row->qty; ?></td>
                            <td><?php echo formatCurrency($row->price); ?></td>
                            <td><?php echo formatCurrency($row->total_price); ?></td>
                        </tr>
                        <?php endforeach; ?>

                        <tr>
                            <td></td>
                            <td>JNE <?php echo $transaction->expedition_service_type; ?></td>
                            <td>1</td>
                            <td><?php echo formatCurrency($transaction->shipping_cost); ?></td>
                            <td><?php echo formatCurrency($transaction->shipping_cost); ?></td>
                        </tr>

                        @if (!empty($voucher))
                            <tr>
                                <td></td>
                                <td>Voucher Id</td>
                                <td>
                                    @if ($voucher->is_percent == 'y')
                                        @php
                                            $voucher->value . ' %';
                                        @endphp
                                    @else
                                        @php
                                            $voucher->value . ' Off';
                                        @endphp
                                    @endif
                                </td>
                                <td></td>
                                <td></td>
                            </tr>
                        @endif

                        <tr class="table-success">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>Grand Total</td>
                            <td><?php echo formatCurrency($transaction->final_price); ?></td>
                        </tr>
                    </tbody>
                </table>

                <small class="text-muted" id="label_payment_method"></small>
            </div>
        </div>



        <div class="d-flex justify-content-center mt-3">
            <a class="btn btn-secondary previous" href="{{ url()->previous() }}"><i class="fas fa-angle-left"></i>
                {{ __('general.back') }}</a>
        </div>
    </div>
    <div class="card-footer px-3 border-0 d-flex flex-column flex-lg-row align-items-center justify-content-end">
        {{-- {{ $socialMedia->links() }} --}}
    </div>
    </div>
@endsection
