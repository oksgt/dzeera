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
                    <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">Orders</a></li>
                </ol>
            </nav>
            <h2 class="h4">Order List</h2>
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

    <div class="card card-body border-0 shadow table-wrapper ">
        <div class="card-header border-0 d-flex flex-column flex-lg-row align-items-center justify-content-start">
            <div class="mb-0">
                <form action="{{ route('orders.index') }}" method="GET">
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1">
                        <svg class="icon icon-xxs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                        </span>
                        <input type="text" class="form-control" name="q" value="{{ $query }}" placeholder="Search" aria-label="Search">
                    </div>
                </form>
            </div>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-hover table-auto">
                <thead>
                    <tr>
                        <th class="border-gray-200">{{ __('No') }}</th>
                        <th class="border-gray-200">
                            <a href="{{ route('orders.index', ['sort' => 'trans_number', 'dir' => ($column == 'trans_number' && $direction == 'asc') ? 'desc' : 'asc']) }}">
                                Code {!! ($column == 'trans_number') ? '<i class="fas fa-sort-' . (($direction == 'asc') ? 'up' : 'down') . '"></i>' : '' !!}
                            </a>
                        </th>
                        <th class="border-gray-200">
                            <a href="{{ route('orders.index', ['sort' => 'created_at', 'dir' => ($column == 'created_at' && $direction == 'asc') ? 'desc' : 'asc']) }}">
                                Date {!! ($column == 'created_at') ? '<i class="fas fa-sort-' . (($direction == 'asc') ? 'up' : 'down') . '"></i>' : '' !!}
                            </a>
                        </th>
                        <th class="border-gray-200">
                            <a href="{{ route('orders.index', ['sort' => 'cust_name', 'dir' => ($column == 'cust_name' && $direction == 'asc') ? 'desc' : 'asc']) }}">
                                Buyer {!! ($column == 'cust_name') ? '<i class="fas fa-sort-' . (($direction == 'asc') ? 'up' : 'down') . '"></i>' : '' !!}
                            </a>
                        </th>
                        <th class="border-gray-200">
                            <a href="{{ route('orders.index', ['sort' => 'recp_name', 'dir' => ($column == 'recp_name' && $direction == 'asc') ? 'desc' : 'asc']) }}">
                                Shippment {!! ($column == 'recp_name') ? '<i class="fas fa-sort-' . (($direction == 'asc') ? 'up' : 'down') . '"></i>' : '' !!}
                            </a>
                        </th>
                        <th class="border-gray-200">
                            <a href="{{ route('orders.index', ['sort' => 'amount', 'dir' => ($column == 'amount' && $direction == 'asc') ? 'desc' : 'asc']) }}">
                                Amount {!! ($column == 'amount') ? '<i class="fas fa-sort-' . (($direction == 'asc') ? 'up' : 'down') . '"></i>' : '' !!}
                            </a>
                        </th>
                        <th class="border-gray-200">
                            <a href="{{ route('orders.index', ['sort' => 'payment_method', 'dir' => ($column == 'payment_method' && $direction == 'asc') ? 'desc' : 'asc']) }}">
                                Payment Method {!! ($column == 'payment_method') ? '<i class="fas fa-sort-' . (($direction == 'asc') ? 'up' : 'down') . '"></i>' : '' !!}
                            </a>
                        </th>
                        <th class="border-gray-200">
                            <a href="{{ route('orders.index', ['sort' => 'trans_status', 'dir' => ($column == 'trans_status' && $direction == 'asc') ? 'desc' : 'asc']) }}">
                                Status {!! ($column == 'trans_status') ? '<i class="fas fa-sort-' . (($direction == 'asc') ? 'up' : 'down') . '"></i>' : '' !!}
                            </a>
                        </th>
                        <th class="border-gray-200">{{ __('#') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $row)
                        <tr>
                            <td><span class="fw-normal">{{ $counter++ }}</span></td>
                            <td><span class="fw-normal">{{ $row->trans_number }}</span></td>
                            <td><span class="fw-normal">{{ $row->created_at }}</span></td>
                            <td><span class="fw-normal">{{ $row->cust_name }}</span></td>

                            <td><span class="fw-normal">{{ $row->recp_name }}</span></td>
                            <td><span class="fw-normal">{{ formatCurrency($row->final_price) }}</span></td>
                            <td><span class="fw-normal">{{ $row->payment_method }}</span></td>
                            <td>
                                @php
                                    $currentDateTime = new DateTime(); // Get the current date and time
                                    $givenDateTime = new DateTime($row->max_time); // Convert the given time string to a DateTime object

                                @endphp
                                @if ($row->payment_method == 'Bank Transfer')

                                @if ($givenDateTime < $currentDateTime )

                                    <h5><span class="badge bg-danger">Cancelled</span></h5>

                                @else
                                    @if ($row->trans_status == 'paid')
                                        <h5><span class="badge bg-success">Paid</span></h5>
                                    @else
                                        <h5><span class="badge bg-warning">Unpaid</span></h5>
                                    @endif
                                @endif

                            @else
                                <h5><span class="badge bg-{{ $row->trans_status == 'paid' ? 'success' : 'warning' }}">{{ ucwords($row->trans_status) }}</span></h5>
                            @endif
                            </td>
                            <td>
                                <a type="button" class="btn btn-sm btn-primary d-inline-flex align-items-center"
                                    href="{{ route('orders.details', ['trans_number' => $row->trans_number]) }}">
                                    Details
                                </a>
                                {{-- <a type="button" class="btn btn-sm btn-secondary d-inline-flex align-items-center"
                                    href="{{ route('orders.delete', ['orders' => $row]) }}">
                                    Delete
                                </a> --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer px-3 border-0 d-flex flex-column flex-lg-row align-items-center justify-content-end">
            {{-- {{ $socialMedia->links() }} --}}
        </div>
    </div>
@endsection
