<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Orderline;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        if (isset($request->order_id)) {
            $order = Order::find($request->order_id);
            $orderline = Orderline::where('order_id', $order->id)->get();
            $datetrx = $order->dateordered;

            try {
                DB::beginTransaction();
                foreach ($orderline as $key => $line) {
                    Transaction::firstOrCreate(
                        [
                            'movementdate' => $datetrx,
                            'movementqty' => $order->issotrx == true ? (-$line->qty) : $line->qty,
                            'product_id' => $line->product_id,
                            'orderline_id' => $line->id
                        ]
                    );

                    $product = Product::find($line->product_id);
                    $stock = $product->stock;
                    $product->update([
                        'stock' => $stock + ($order->issotrx == true ? (-$line->qty) : $line->qty)
                    ]);

                    $order->update([
                        'docstatus' => 'CO'
                    ]);
                }

                DB::commit();

                return back()->with('success', $order->invoice . ' Processed succeffully.');
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json([
                    'status' => 'failed',
                    'message' => $e->getMessage()
                ]);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
