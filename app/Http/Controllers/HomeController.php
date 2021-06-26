<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Partner;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    /*public function __construct()
    {
        $this->middleware('auth');
    }*/

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {


        #dd(session()->get('identity'));


        $product = Product::count();
        $order = Order::count();
        $partner = Partner::count();
        $user = User::count();

        return view('home', compact('product', 'order', 'partner', 'user'));
    }

    public function getChart()
    {
        $startdate = Carbon::now()->subWeek()->addDay()->format('Y-m-d') . ' 00:00:01';
        $enddate = Carbon::now()->format('Y-m-d') . ' 23:59:00';

        $order = Order::select(DB::raw("date(created_at) as datetrx"), DB::raw("count(*) as total"))
            ->whereBetween('created_at', [$startdate, $enddate])
            ->groupBy('datetrx')
            ->get()->all();

        for ($i = Carbon::now()->subWeek()->addDay(); $i <= Carbon::now(); $i->addDay()) {

            if (!array_search($i->format('Y-m-d'), array_column($order, 'datetrx'))) {
                array_push($order, ['datetrx' => $i->format('Y-m-d'), 'total' => 0]);
            }
            sort($order);
        }
        return response()->json($order);
    }
}
