<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice #{{ $order->invoice }}</title>
    <style>
        body {
            padding: 0;
            margin: 0;
        }

        .page {
            max-width: 80em;
            margin: 0 auto;
            background: #D5E0CC;
        }

        table th,
        table td {
            text-align: left;
        }

        table.layout {
            width: 100%;
            border-collapse: collapse;
        }

        table.display {
            margin: 1em 0;
        }

        table.display th,
        table.display td {
            border: 1px solid #B3BFAA;
            padding: .5em 1em;
        }

        ​ table.display th {
            background: #D5E0CC;
        }

        table.display td {
            background: #fff;
        }

        ​ table.responsive-table {
            box-shadow: 0 1px 10px rgba(0, 0, 0, 0.2);
        }

        ​ .listcust {
            margin: 0;
            padding: 0;
            list-style: none;
            display: table;
            border-spacing: 10px;
            border-collapse: separate;
            list-style-type: none;
        }

        .partner {
            padding-left: 600px;
        }
    </style>
</head>

<body>
    <div class="header">
        <p>
            <strong>{{ session('identity')[0]['name'] }}</strong><br>
            {{ session('identity')[0]['address'] }} <br>
            Phone :{{ session('identity')[0]['phone'] }}
        </p>
        <hr>
        <h4 style="line-height: 0px;">Invoice: #{{ $order->invoice }}</h4>
        <p><small style="opacity: 0.5;">Tanggal : {{ date('d F Y', strtotime($order->dateordered)) }}</small></p>
    </div>
    <div class="partner">
        <table>
            <tr>
                <th>Nama Pelanggan</th>
                <td>:</td>
                <td>{{ $order->partner->name }}</td>
            </tr>
            <tr>
                <th>No Telp</th>
                <td>:</td>
                <td>{{ $order->partner->phone }}</td>
            </tr>
            <tr>
                <th>Alamat</th>
                <td>:</td>
                <td>{{ $order->partner->address }}</td>
            </tr>
        </table>
    </div>
    <div class="page">
        <table class="layout display responsive-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @php
                $no = 1;
                $totalPrice = 0;
                $totalQty = 0;
                $total = 0;
                @endphp
                @forelse ($order->orderline as $row)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $row->product->name }}</td>
                    <td>Rp {{ number_format($row->price) }}</td>
                    <td>{{ $row->qty }} Item</td>
                    <td>Rp {{ number_format($row->price * $row->qty) }}</td>
                </tr>
                ​
                @php
                $totalPrice += $row->price;
                $totalQty += $row->qty;
                $total += ($row->price * $row->qty);
                @endphp
                @empty
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data</td>
                </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="2">Total</th>
                    <td>Rp {{ number_format($totalPrice) }}</td>
                    <td>{{ number_format($totalQty) }} Item</td>
                    <td>Rp {{ number_format($total) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</body>

</html>
