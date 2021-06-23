<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:product-list|product-create|product-edit|product-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:product-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:product-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:product-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::with('category')->orderBy('created_at', 'DESC')->paginate(2);
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::orderBy('name', 'DESC')->get();
        $code = Str::random(10);

        return view('products.create', compact('categories', 'code'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validasi data
        $this->validate($request, [
            'code' => 'required|string|max:10|unique:products',
            'name' => 'required|string|max:100',
            'description' => 'nullable|string|max:100',
            'stock' => 'required|integer',
            'price' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'photo' => 'nullable|image|mimes:jpg,png,jpeg'
        ]);

        try {
            //default $photo = null
            $photo = null;
            //jika terdapat file (Foto / Gambar) yang dikirim
            if ($request->hasFile('photo')) {
                //maka menjalankan method saveFile()
                $photo = $this->saveFile($request->name, $request->file('photo'));
            }


            //Simpan data ke dalam table products
            $product = Product::create([
                'code' => $request->code,
                'name' => $request->name,
                'description' => $request->description,
                'stock' => $request->stock,
                'price' => $request->price,
                'category_id' => $request->category_id,
                'photo' => $photo
            ]);

            //jika berhasil direct ke produk.index
            return redirect(route('products.index'))
                ->with(['success' => '<strong>' . $product->name . '</strong> Ditambahkan']);
        } catch (\Exception $e) {
            //jika gagal, kembali ke halaman sebelumnya kemudian tampilkan error
            return redirect()->back()
                ->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Save the specified photo.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function saveFile($name, $photo)
    {
        //set nama file adalah gabungan antara nama produk dan time(). Ekstensi gambar tetap dipertahankan
        $images = Str::slug($name) . time() . '.' . $photo->getClientOriginalExtension();
        //set path untuk menyimpan gambar
        $path = public_path('uploads/product');

        Image::make($photo)->save($path . '/' . $images);

        return $images;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::orderBy('name', 'ASC')->get();
        return view('products.edit', compact('product', 'categories'));
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
        $this->validate($request, [
            'code' => 'required|string|max:10|exists:products,code',
            'name' => 'required|string|max:100',
            'description' => 'nullable|string|max:100',
            'stock' => 'required|integer',
            'price' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'photo' => 'nullable|image|mimes:jpg,png,jpeg'
        ]);

        try {
            $product = Product::findOrFail($id);
            $photo = $product->photo;

            if ($request->hasFile('photo')) {
                !empty($photo) ? File::delete(public_path('uploads/product/' . $product->photo)) : null;

                $photo = $this->saveFile($request->name, $request->file('photo'));
            }

            $product->update([
                'name' => $request->name,
                'description' => $request->description,
                'stock' => $request->stock,
                'price' => $request->price,
                'category_id' => $request->category_id,
                'photo' => $photo
            ]);

            return redirect(route('products.index'))->with(['success' => '<strong>' . $product->name . '</strong> Updated.']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        if (!empty($product->photo)) {
            File::delete(public_path('uploads/product/' . $product->photo));
        }
        $product->delete();
        return redirect()->back()->with(['success' => '<strong>' . $product->name . '</strong> Deleted.']);
    }
}
