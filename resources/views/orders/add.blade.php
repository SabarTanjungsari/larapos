@extends('layouts.master')

@section('title')
<title>Transaction</title>
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
                    <h1 class="m-0">Transaction</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Transaction</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content" id="dw">
        <div class="container-fluid">
            @if (session('error'))
            <x-alert type="danger">{!! session('error') !!}</x-alert>
            @endif
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-md-4">
                    <x-card title="" footer="">
                        <div class="row">
                            <div class="col-md-12">
                                <form action="formAddCart">
                                    <div class="form-group">
                                        <label for="">Product</label>
                                        <select onchange="getDetailProduct()" name="product_id" id="product_id"
                                            class="form-control form-control-sm myselect" required width="100%">
                                            <option value="">Change</option>
                                            @foreach ($products as $product)
                                            <option value="{{$product->id}}">{{$product->code}} - {{$product->name}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="">&nbsp;</label>
                                        <a href="" id="addCart" class="btn btn-primary btn-block">
                                            <i class="fas fa-cart-plus fa-lg mr-2"></i>
                                            Add to Cart
                                        </a>
                                    </div>
                                </form>

                                <div class="form-group">
                                    <p class="btn-holder">

                                    </p>

                                </div>

                                <h4>Detail Product</h4>
                                <div>
                                    <table class="table table-striped">
                                        <tr>
                                            <th width="3%">Product</th>
                                            <td width="2%">:</td>
                                            <td id="name"></td>
                                        </tr>
                                        <tr>
                                            <th>Price</th>
                                            <td>:</td>
                                            <td id="price"></td>
                                        </tr>
                                        <tr>
                                            <th>Stock</th>
                                            <td>:</td>
                                            <td id="stock"></td>
                                        </tr>
                                    </table>
                                </div>

                                <div id="showImage" class="d-none">
                                    <img id="photo" class="img-rounded mr-3 img-circle" src="" alt="" width="300px">
                                </div>
                            </div>

                        </div>

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
<script type="text/javascript">
    function getDetailProduct() {
    var id = $('[name="product_id"]').val();

    if (id != '') {
        $.ajax({
            url: APP_URL + "/api/product/" + id,
            type: "GET",
            dataType: "JSON",
            success: function (data) {
                $('#addCart').attr('href', APP_URL + '/add-to-cart/' + id);
                $('#name').html(data.code + '# ' + data.name);
                $('#price').html(
                    accounting.formatMoney(data.price,  {
                        symbol: 'Rp. '
                    })
                );
                $('#stock').html(
                    accounting.toFixed(data.stock, 0)
                );
                $('#showImage').removeClass('d-none');
                if(data.photo){
                    $('#photo').attr('src', APP_URL + '/uploads/product/' + data.photo);
                } else {
                    $('#photo').attr('src', APP_URL + '/dist/img/50x50.png');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error get data from ajax");
            },
        });
    }
}

    $(".update-cart").change(function (e) {
        e.preventDefault();
        var ele = $(this);
        $.ajax({
            url: '{{ route('update.cart') }}',
            method: "patch",
            data: {
                _token: '{{ csrf_token() }}',
                id: ele.parents("tr").attr("data-id"),
                quantity: ele.parents("tr").find(".quantity").val()
            },
            success: function (response) {
               window.location.reload();
            }
        });
    });
    $(".remove-from-cart").click(function (e) {
        var ele = $(this);
        var currentRow=$(this).closest("tr");
        Swal.fire({
        title: 'Are you sure delete ?',
        text: currentRow.find("td:eq(0)").text(),
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('remove.from.cart') }}',
                        method: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: ele.parents("tr").attr("data-id")
                        },
                        success: function (response) {
                            window.location.reload();
                        }
                    });
                }
            })
    });
    $(".checkout-cart").click(function (e) {
        e.preventDefault();
        var ele = $(this);
        $('#checkoutCart').attr('href', APP_URL + 'checkout-cart');
    });
</script>
@endsection
