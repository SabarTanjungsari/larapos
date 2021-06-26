<?php

namespace App\Http\Controllers;

use App\Exports\OrderInvoice;
use App\Models\Order;
use App\Models\Partner;
use App\Models\Product;
use App\Models\User;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:sales-list|sales-create|sales-edit|sales-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:sales-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:sales-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:sales-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $partners = Partner::where('iscustomer', true)->orderBy('name', 'ASC')->get();
        $users = User::orderBy('name', 'ASC')->get();
        $orders = Order::where('issotrx', true)->orderBy('created_at', 'DESC')->with('orderline', 'partner', 'user');

        # By Partner
        if (!empty($request->partner_id)) {
            $orders = $orders->where('partner_id', $request->partner_id);
        }

        # By User - Cashier
        if (!empty($request->user_id)) {
            $orders = $orders->where('user_id', $request->user_id);
        }

        # By Periode
        if (!empty($request->startdate) && !empty($request->enddate)) {
            $this->validate($request, [
                'startdate' => 'nullable|date',
                'enddate' => 'nullable|date'
            ]);

            # Format Date
            $startdate = Carbon::parse($request->startdate)->format('Y-m-d') . ' 00:00:01';
            $enddate = Carbon::parse($request->enddate)->format('Y-m-d') . ' 23:59:59';

            # Add condision Between
            $orders = $orders->whereBetween('created_at', [$startdate, $enddate])->get();
        } else {
            $orders = $orders->take(10)->skip(0)->get();
        }

        return view('orders.index', [
            'orders' => $orders,
            'sold' => $this->countItem($orders),
            'total' => $this->countTotal($orders),
            'total_partner' => $this->countPartner($orders),
            'partners' => $partners,
            'users' => $users,
            'cashiers' => $this->countCashier($orders)
        ]);
    }

    private function countCashier($orders)
    {
        $cashiers = [];
        if ($orders->count() > 0) {
            foreach ($orders as $row) {
                $cashiers[] = $row->user->name;
            }
        }

        return count(array_unique($cashiers));
    }

    private function countPartner($orders)
    {
        $partner = [];
        if ($orders->count() > 0) {
            foreach ($orders as $row) {
                $partner[] = $row->partner->name;
            }
        }

        return count(array_unique($partner));
    }

    private function countTotal($orders)
    {
        $total = 0;
        if ($orders->count() > 0) {
            $sub_total = $orders->pluck('grandtotal')->all();
            $total = array_sum($sub_total);
        }
        return $total;
    }

    private function countItem($orders)
    {
        $data = 0;
        if ($orders->count() > 0) {
            foreach ($orders as $row) {
                $qty = $row->orderline->pluck('qty')->all();
                $val = array_sum($qty);
                $data += $val;
            }
        }

        return $data;
    }

    public function invoicePdf($invoice)
    {
        $order = Order::where('invoice', $invoice)
            ->with('partner', 'orderline', 'orderline.product')->first();

        $pdf = PDF::setOptions(
            ['dpi' => 150, 'defaultFont' => 'sans-serif']
        )
            ->loadView('orders.report.invoice', compact('order'))
            ->setPaper('A5', 'landscape');

        return $pdf->stream();
    }

    public function invoiceExcel($invoice)
    {
        return (new OrderInvoice($invoice))->download('invoice-' . $invoice . '.xlsx');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function addOrder()
    {
        $products = Product::orderBy('created_at', 'DESC')->get();
        return view('orders.add', compact('products'));
    }

    public function addToCart($id)
    {
        $product = Product::findOrFail($id);

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                "photo" => $product->photo,
                "stock" => $product->stock
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function updateCart(Request $request)
    {
        if ($request->id && $request->quantity) {
            $cart = session()->get('cart');
            $cart[$request->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);
            session()->flash('success', 'Cart updated successfully');
        }
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function removeCart(Request $request)
    {
        if ($request->id) {
            $cart = session()->get('cart');
            if (isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            session()->flash('success', 'Product removed successfully');
        }
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function checkoutCart()
    {
        $cart = session()->get('cart');
        if ($cart) {
            $date = date('Y-m-d');
            return view('orders.checkout', compact('date'));
        } else {
            return redirect()->back()->with('error', 'Cart is empty.');
        }
    }

    public function storeOrder(Request $request)
    {
        #dd($request->issotrx);
        $this->validate($request, [
            'email' => 'email|required',
            'name' => 'required|string|max:100',
            'address' => 'required',
            'phone' => 'required'
        ]);

        $cart = session()->get('cart');

        $total = 0;
        foreach ((array) session('cart') as $id => $details) {
            $total += $details['price'] * $details['quantity'];
        }

        DB::beginTransaction();
        try {

            $partner = Partner::firstOrCreate([
                'email' => $request->email
            ], [
                'name' => $request->name,
                'address' => $request->address,
                'phone' => $request->phone,
                'isactive' => true,
                'iscustomer' => true,
                'isvendor' => false
            ]);

            $order = Order::create([
                'invoice' => $this->generateInvoice(),
                'partner_id' => $partner->id,
                'createdby' => auth()->user()->id,
                'grandtotal' => $total,
                'dateordered' => $request->dateordered,
                'issotrx' => $request->issotrx
            ]);
            foreach ((array) session('cart') as $id => $item) {
                $order->orderline()->create([
                    'product_id' => $id,
                    'qty' => $item['quantity'],
                    'price' => $item['price']
                ]);
            }

            DB::commit();
            session()->forget('cart');
            return redirect()->route('order.transaction')->with('success', 'Order added successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'failed',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function generateInvoice()
    {
        $order = Order::orderBy('created_at', 'DESC');
        if ($order->count() > 0) {
            $order = $order->first();
            $explode = explode('-', $order->invoice);
            return 'INV-' . ($explode[1] + 1);
        }
        return 'INV-1';
    }
}
