<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class PartnerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:partner-list|partner-create|partner-edit|partner-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:partner-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:partner-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:partner-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $partners = Partner::orderBy('updated_at', 'DESC')->paginate(5);

        return view('partners.index', compact('partners'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $partner = new Partner();
        return view('partners.partner', compact('partner'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $partner = new Partner(
            $request->all()
        );

        $validator = Validator::make(
            request()->all(),
            $partner->rules
        );
        $errors = $validator->errors();
        if ($errors->any()) {
            return view('partners.partner', compact('partner', 'errors'));
        }

        $partner->save();
        return redirect(route('partners.index'))
            ->with(['success' => '<strong>' . $partner->name . '</strong> added successfully.']);
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
        $partner = Partner::find($id);
        return view('partners.partner', compact('partner'));
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
        $partner = new Partner(
            $request->all()
        );

        $rules = $partner->rules;
        $rules['email'] = $rules['email'] . ',email,' . $id;
        $validator = Validator::make(
            request()->all(),
            $rules
        );
        $errors = $validator->errors();
        if ($errors->any()) {
            return view('partners.partner', compact('partner', 'errors'));
        }

        $customer = $partner->iscustomer == "on" ? true : false;
        $vendor = $partner->isvendor == "on" ? true : false;
        $active = $partner->isactive == "on" ? true : false;

        $request['iscustomer'] = $customer;
        $request['isvendor'] = $vendor;
        $request['isactive'] = $active;

        #dd($request->all());
        $updated = Partner::findOrFail($id);
        $updated->update($request->all());
        return redirect(route('partners.index'))
            ->with(['success' => '<strong>' . $partner->name . '</strong> updated successfully.']);
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
}
