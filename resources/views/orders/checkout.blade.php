@extends('layouts.master')

@section('title')
<title>Checkout</title>
@endsection

@section('css')
<link href="{{ asset('plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('plugins/sweetalert2/sweetalert2.css') }}" rel="stylesheet" />
@endsection

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Checkout</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('order.transaction') }}">Transaction</a></li>
                        <li class="breadcrumb-item active">Checkout</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content" id="dw">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-md-4">
                    <x-card title="Customer Data" footer="">
                        <form role="form" action="{{ route('order.storeOrder') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Customer</label>
                                        <select class="form-control form-control-sm myselect"
                                            onchange="getDetailPartner()" name="partner_id" id="partner_id">
                                        </select>
                                    </div>
                                    <div>
                                        <label for="">Name</label>
                                        <input type="text" name="name" id="name" class="form-control input-sm" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Adress</label>
                                        <textarea name="address" id="address" cols="5" rows="5" class="form-control"
                                            required></textarea>
                                    </div>
                                    <div>
                                        <label for="">Email</label>
                                        <input type="email" name="email" id="email" class="form-control input-sm">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Phone No.</label>
                                        <input type="text" name="phone" id="phone" class="form-control input-sm">
                                    </div>
                                </div>
                            </div>

                            @slot('footer')
                            <div class="card-footer text-muted">
                                <button id="sendOrder" class="btn btn-primary btn-sm float-right">
                                    Order Now
                                </button>
                            </div>
                        </form>
                        @endslot
                    </x-card>
                </div>

                @include('orders.cart')

            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>

@endsection

@section('js')
<script src="{{ asset('plugins/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('js/accounting.min.js') }}"></script>
<script src="{{ asset('js/transaction.js') }}"></script>
<script type="text/javascript">
    $.ajax({
        url: '{{ route('partner') }}',
        type: "GET",
        dataType: "JSON",
        success: function(data) {
            var dropdownRequest = $("#partner_id");
            dropdownRequest.empty();
            $("<option></option>").attr("value", "").text("- Select -")
            $.each(data, function(key, entry) {
                dropdownRequest.append(
                    $("<option></option>").attr("value", entry.id).text(entry.name + " (" + entry.email + ")")
                );
            });
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert("Error get data from ajax");
        },
    });

    function getDetailPartner() {
        var id = $('[name="partner_id"]').val();
        var APP_URL = window.location.origin;

        if (id != '') {
            $.ajax({
                url: APP_URL + "/api/partner/" + id,
                type: "GET",
                dataType: "JSON",
                success: function (data) {
                    $('#name').val(data.name);
                    $('#email').val(data.email);
                    $('#address').val(data.address);
                    $('#phone').val(data.phone);
                    $('#sendOrder').removeClass('disabled');
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert("Error get data from ajax");
                },
            });
        }
    }

</script>
@endsection
