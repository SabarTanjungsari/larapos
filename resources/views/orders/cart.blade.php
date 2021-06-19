<div class="col-md-8">
    <x-card title="" footer="">
        @slot('title')
        Cart
        @endslot

        <table id="cart" class="table table-hover table-condensed">
            <thead>
                <tr>
                    <th style="width:50%">Product</th>
                    <th style="width:10%">Price</th>
                    <th style="width:8%">Quantity</th>
                    <th style="width:22%" class="text-center">Subtotal</th>
                    <th style="width:10%"></th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0 @endphp
                @if(session('cart'))
                @foreach(session('cart') as $id => $details)
                @php $total += $details['price'] * $details['quantity'] @endphp
                <tr data-id="{{ $id }}">
                    <td data-th="Product">
                        <div class="row">
                            <div class="col-sm-3 hidden-xs"><img
                                    src="{{ $details['photo'] ? asset('uploads/product/'. $details['photo']) : 'http://via.placeholder.com/50x50'}}"
                                    class="img-size-50 mr-3 img-circle" />
                            </div>
                            <div class="col-sm-9">
                                <h4 class="nomargin">{{ $details['name'] }}</h4>
                            </div>
                        </div>
                    </td>
                    <td data-th="Price" class="text-right">{{ number_format($details['price']) }}</td>
                    <td data-th="Quantity" class="text-right">
                        <input type="number" value="{{ $details['quantity'] }}"
                            class="form-control quantity update-cart" />
                    </td>
                    <td data-th="Subtotal" class="text-right">
                        {{ number_format($details['price'] * $details['quantity']) }}</td>
                    <td class="actions" data-th="">
                        <button class="btn btn-danger btn-sm remove-from-cart"><i class="fa fa-trash"></i></button>
                    </td>
                </tr>
                @endforeach
                @endif
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5" class="text-right">
                        <h3><strong>Total {{ number_format($total) }}</strong></h3>
                    </td>
                </tr>
                <tr>
                    <td colspan="5" class="text-right">
                        @if (url()->current() == route('order.transaction'))
                        <a href="{{ route('checkout.from.cart') }}" class="btn btn-warning"><i
                                class="fa fa-shopping-cart"></i> Checkout
                        </a>
                        @else
                        <a href="{{ route('order.transaction') }}" class="btn btn-secondary btn-sm float-right">
                            Kembali
                        </a>
                        @endif
                    </td>
                </tr>
            </tfoot>
        </table>

    </x-card>
</div>
