@extends('layouts.master')

@section('title')
    <title>Penjualan</title>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <form action="" method="POST" id="dynamicForm">
                    @csrf

                    @if (Session::has('success'))
                        <div class="alert alert-success text-center">
                            <a href="" class="close" data-dismiss="alert" aria-label="close">x</a>
                            <p>{{ Session::get('success') }}</p>
                        </div>
                    @endif

                    @if (Session::has('errors'))
                        <div class="alert alert-danger text-center">
                            <a href="" class="close" data-dismiss="alert" aria-label="close">x</a>
                            <p>{{ Session::get('errors') }}</p>
                        </div>
                    @endif

                    <table class="table table-bordered" id="dynamicTable">
                        <thead class="thead-dark">
                            <tr class="text-center">
                                <th width="15%">Barcode</th>
                                <th width="30%">Name</th>
                                <th width="10%">Qty</th>
                                <th width="15%">Price</th>
                                <th width="15%">Line Amount</th>
                                <th width="5%">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td>
                                    <input type="text" name="addMore[0][barcode]" id="barcode_0" class="form-control"
                                        onkeypress="scanBarcode(0)">
                                    <input type="hidden" name="addMore[0][product_id]" id="product_id_0"
                                        class="form-control">
                                </td>
                                <td>
                                    <input type="text" name="addMore[0][name]" id="name_0" class="form-control" readonly>
                                </td>
                                <td><input type="number" name="addMore[0][qty]" id="qty_0" class="form-control"
                                        onchange="updateRow(0)"></td>
                                <td class="text-right"><input type="text" name="addMore[0][price]" id="price_0"
                                        class="form-control" readonly></td>
                                <td class="text-right"><input type="text" name="addMore[0][amount]" id="amount_0"
                                        class="form-control" readonly></td>
                                <td>
                                    <button type="button" name="add" id="add" class="btn btn-outline-success">
                                        <i class="fas fa-plus-circle"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" class="text-center text-bold">TOTAL</td>
                                <td class="text-right">
                                    <input type="text" name="total" id="total" class="form-control" readonly>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </form>
                <button class="btn btn-outline-primary add-order"> <i class="fas fa-plus-square"></i></button>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        var i = 0;
        var row = '';

        $('#add').click(function() {
            ++i;
            row = createRow(i);
            $("#dynamicTable").append(row);

        });

        $(document).on('click', '.remove-tr', function() {
            $(this).parents('tr').remove();
        });

        function updateRow($i) {
            var amount = $('#amount_' + $i).val();
            var qty = $('#qty_' + $i).val();
            var price = $('#price_' + $i).val();
            var total = $('#total').val();
            var exclude = total - amount;

            if (qty < 1) {
                $('#qty_' + $i).val(1);
            }
            lineamt = $('#qty_' + $i).val() * price;
            $('#amount_' + $i).val(lineamt);
            $('#total').val(exclude + lineamt);
        }

        function scanBarcode($i) {
            var grandtotal = $('#total').val();
            var code = $('#barcode_' + $i).val();
            var URL = "{{ url('/api/products') }}/" + code;
            $.ajax({
                url: URL,
                method: "GET",
                async: true,
                dataType: "json",
                success: function(response) {
                    amount = response.data['price'];
                    $('#product_id_' + $i).val(response.data['id']);
                    $('#name_' + $i).val(response.data['name']);
                    $('#qty_' + $i).val(1);
                    $('#price_' + $i).val(amount);
                    $('#amount_' + $i).val(amount);

                    var total = (+amount) + (+grandtotal);
                    $('#total').val(total);
                },
            });
            return false;

        }

        $('.add-order').click(function() {
            var ACTION = "{{ URL('cashiers') }}";
            $('#dynamicForm').attr('action', ACTION);
            $('#method').val('POST');
            $("#dynamicForm").submit();
        });

        function createRow($i) {
            var str = '';
            str = '<tr>' +
                '<td>' +
                '<input type="text" name="addMore[' + $i + '][barcode]" class="form-control" id="barcode_' + $i +
                '" onkeypress="scanBarcode(' + $i + ')">' +
                '<input type="hidden" name="addMore[' + $i + '][product_id]" id="product_id_' + $i +
                '" class="form-control">' +
                '</td>' +
                '<td><input type="text" name="addMore[' + $i + '][name]" id="name_' + $i +
                '" class="form-control" readonly></td>' +
                '<td><input type="number" name="addMore[' + $i + '][qty]" id="qty_' + $i +
                '" class="form-control"  onchange="updateRow(' + $i + ')"></td>' +
                '<td class="text-right"><input type="text" name="addMore[' + $i + '][price]" id="price_' + $i +
                '" class="form-control" readonly></td>' +
                '<td class="text-right"><input type="text" name="addMore[' + $i + '][amount]" id="amount_' + $i +
                '" class="form-control" readonly></td>' +
                '<td>' +
                '<button type="button" name="add" id="add" class="btn btn-outline-danger remove-tr">' +
                '<i class="fas fa-minus-circle"></i>' +
                '</button>' +
                '</td>' +
                '</tr>';

            return str;
        }
    </script>
@endsection
