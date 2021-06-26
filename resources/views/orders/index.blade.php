@extends('layouts.master')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">List Transaction
                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">
                            <i class="fa fa-search"></i>
                        </button>
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Order</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $sold }}</h3>

                        <p>Items Sold</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>Rp {{ number_format($total) }}</h3>

                        <p>Total Sales</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="{{ route('order.index') }}" class="small-box-footer">More info <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3>{{ $total_partner }}</h3>

                        <p>Total Customers</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-purple">
                    <div class="inner">
                        <h3>{{ $cashiers }}</h3>

                        <p>Total Cashier</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>
        <div class="row">
            <div class="col-md-12">
                <x-card title="" footer="">
                    @slot('title')
                    Data Transaction
                    @endslot

                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead>
                                <tr class="text-center">
                                    <th>Invoice</th>
                                    <th>Partner</th>
                                    <th>Phone No</th>
                                    <th>Total</th>
                                    <th>Cashier</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- LOOPING MENGGUNAKAN FORELSE, DIRECTIVE DI LARAVEL 5.6 -->
                                @forelse ($orders as $row)
                                <tr class="{{$row->docstatus == 'CO' ? 'text-primary' : ''}}">
                                    <td><strong>#{{ $row->invoice }}</strong></td>
                                    <td>{{ $row->partner->name }}</td>
                                    <td class="text-center">{{ $row->partner->phone }}</td>
                                    <td class="text-right">{{ number_format($row->grandtotal) }}</td>
                                    <td class="text-center">{{ $row->user->name }}</td>
                                    <td class="text-center">{{ $row->dateordered }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('order.pdf', $row->invoice) }}" target="_blank"
                                            class="btn btn-primary btn-sm">
                                            <i class="fa fa-print"></i>
                                        </a>
                                        <a href="{{ route('order.excel', $row->invoice) }}" target="_blank"
                                            class="btn btn-info btn-sm">
                                            <i class="fa fa-file-excel"></i>
                                        </a>
                                        @can('transaction-create')
                                        <form style="display: inline"
                                            action="{{ $row->docstatus == 'DR' ? route('transactions.store') : 'orders'}}"
                                            method="POST">
                                            @csrf
                                            <input type="hidden" name="order_id" value="{{$row->id}}">

                                            <button onclick="{{$row->docstatus == 'CO' ? 'this.disabled=true;' : ''}}"
                                                class="btn btn-danger btn-sm {{$row->docstatus == 'CO' ? 'disabled' :''}}"
                                                type="submit">
                                                <i class="fa fa-spinner"></i>
                                            </button>
                                        </form>
                                        @endcan
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td class="text-center" colspan="7">Tidak ada data transaksi</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </x-card>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $('#startdate').datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd'
    });

    $('#enddate').datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd'
    });

    function process($id) {
        console.log($id);
    }
</script>

@endsection

<!-- The Modal -->
@section('modal')
<div class="modal" id="myModal">
    <div class="modal-dialog modal-lg   ">
        <div class="modal-content">

            <div class="col-md-12">
                <x-card title="" footer="">
                    @slot('title')
                    Filter Transaction
                    @endslot

                    <form action="{{ route('order.index') }}" method="GET">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Start Date</label>
                                    <input type="text" name="startdate" class="form-control
                                {{$errors->has('startdate') ? 'is-invalid' : ''}}" id="startdate"
                                        value="{{ request()->get('startdate') }}">
                                </div>
                                <div class="form-group">
                                    <label for="">End Date</label>
                                    <input type="text" name="enddate"
                                        class="form-control {{ $errors->has('enddate') ? 'is-invalid':'' }}"
                                        id="enddate" value="{{ request()->get('enddate') }}">
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary btn-sm">Search</button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Partner</label>
                                    <select name="partner_id" class="form-control">
                                        <option value="">Select</option>
                                        @foreach ($partners as $partner)
                                        <option value="{{ $partner->id }}"
                                            {{ request()->get('partner_id') == $partner->id ? 'selected':'' }}>
                                            {{ $partner->name }} - {{ $partner->email }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Cashier</label>
                                    <select name="user_id" class="form-control">
                                        <option value="">Select</option>
                                        @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                            {{ request()->get('user_id') == $user->id ? 'selected':'' }}>
                                            {{ $user->name }} - {{ $user->email }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                </x-card>
            </div>

        </div>
    </div>
</div>
@endsection
