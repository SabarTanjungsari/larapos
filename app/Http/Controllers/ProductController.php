<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as XlsxWritter;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as XlsxReader;
use PhpOffice\PhpSpreadsheet\Style\Border;

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
        $product = new Product();
        $product['code'] = $code;
        return view('products.product', compact('product', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = new Product(
            $request->all()
        );

        $validator = Validator::make(
            request()->all(),
            $product->rules
        );
        $errors = $validator->errors();
        if ($errors->any()) {
            $categories = Category::orderBy('name', 'DESC')->get();
            return view('products.product', compact('categories', 'product', 'errors'));
        }

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
        return view('products.product', compact('product', 'categories'));
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


    public function export()
    {
        $styleBorder = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN //fine border
                ]
            ]
        ];

        $styleBold = [
            'font' => [
                'bold' => true
            ]
        ];

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Product');

        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Produst Name');
        $sheet->setCellValue('C1', 'Active');
        $sheet->setCellValue('D1', 'Description');
        $sheet->setCellValue('E1', 'Stock');
        $sheet->setCellValue('F1', 'Price');
        $sheet->setCellValue('G1', 'Code');
        $sheet->setCellValue('H1', 'ID Category');
        $sheet->setCellValue('I1', 'Category Name');
        $sheet->getStyle('A1:I1')->applyFromArray($styleBold);

        $products = Product::with('category')->get();

        $cell = 2;
        foreach ($products as $product) {
            $sheet->setCellValue('A' . $cell, $product->id);
            $sheet->setCellValue('B' . $cell, $product->name);
            $sheet->setCellValue('C' . $cell, $product->isactive);
            $sheet->setCellValue('D' . $cell, $product->description);
            $sheet->setCellValue('E' . $cell, $product->stock);
            $sheet->setCellValue('F' . $cell, $product->price);
            $sheet->setCellValue('G' . $cell, $product->code);
            $sheet->setCellValue('H' . $cell, $product->category->id);
            $sheet->setCellValue('I' . $cell, $product->category->name);

            $sheet->getStyle('A1' . ':I' . $cell)->applyFromArray($styleBorder);
            $sheet->getStyle('E' . $cell . ':F' . $cell)->getNumberFormat()->setFormatCode('#,##0.00');;
            $cell++;
        }

        foreach (range('A', 'I') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }


        # Category
        $spreadsheet->createSheet();
        $sheet = $spreadsheet->setActiveSheetIndex(1);
        $sheet->setTitle('category');

        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Category Name');
        $sheet->setCellValue('C1', 'Active');
        $sheet->setCellValue('D1', 'Description');
        $sheet->getStyle('A1:D1')->applyFromArray($styleBold);

        $categories = Category::all();
        $cell = 2;
        foreach ($categories as $category) {
            $sheet->setCellValue('A' . $cell, $category->id);
            $sheet->setCellValue('B' . $cell, $category->name);
            $sheet->setCellValue('C' . $cell, $category->isactive);
            $sheet->setCellValue('D' . $cell, $category->description);

            $sheet->getStyle('A1' . ':D' . $cell)->applyFromArray($styleBorder);
            $cell++;
        }

        foreach (range('A', 'D') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $writter = new XlsxWritter($spreadsheet);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename=products.xlsx');
        $writter->save('php://output');
    }

    /**
     * API
     */

    public function getProduct($id)
    {
        $product = Product::findOrFail($id);
        return response()->json($product, 200);
    }
}
