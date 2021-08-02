<?php

namespace App\Http\Controllers;

use App\Models\Category;
use FontLib\Table\Type\name;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as XlsxWritter;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as XlsxReader;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::orderBy('created_at', 'DESC')->paginate(10);
        return view('categories.index', compact('categories'));
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
        $this->validate(
            $request,
            [
                'name' => 'required|string|max:50',
                'description' => 'nullable|string'
            ]
        );

        try {
            $category = Category::firstOrCreate(
                ['name' => $request->name],
                ['description' => $request->description]
            );

            return redirect()->back()->with(['success' => 'Category : ' . $category->name . ' Added.']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
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
        $category = Category::findOrFail($id);
        return view('categories.edit', compact('category'));
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
            'name' => 'required|string|max:50',
            'description' => 'nullable|string'
        ]);

        try {
            $category = Category::findOrFail($id);
            $category->update([
                'name' => $request->name,
                'description' => $request->description
            ]);

            return redirect(route('categories.index'))->with(['success' => 'Category : ' . $category->name . ' Updated.']);
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
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->back()->with(['success' => 'Category : ' . $category->name . ' Deleted.']);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param
     * @return \Illuminate\Http\Response
     */
    public function export()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Category Name');
        $sheet->setCellValue('C1', 'Active');
        $sheet->setCellValue('D1', 'Description');

        $categories = Category::all();
        $cell = 2;
        foreach ($categories as $category) {
            $sheet->setCellValue('A' . $cell, $category->id);
            $sheet->setCellValue('B' . $cell, $category->name);
            $sheet->setCellValue('C' . $cell, $category->isactive);
            $sheet->setCellValue('D' . $cell, $category->description);
            $cell++;
        }

        $writter = new XlsxWritter($spreadsheet);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename=categories.xlsx');
        $writter->save('php://output');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param
     * @return \Illuminate\Http\Response
     */
    public function import(Request $request)
    {
        if ($_POST) {
            $request->validate([
                'file' => 'required|mimes:xlsx|max:1000'
            ]);

            $file = $request->file('file');
            $name = time() . '.xlsx';
            $path = public_path('documents' . DIRECTORY_SEPARATOR);

            if ($file->move($path, $name)) {
                $inputFileName = $path . $name;
                $reader = new XlsxReader();
                $reader->setReadDataOnly(true);
                $reader->setLoadSheetsOnly(["CATEGORY DATA"]);
                $spreadsheet = $reader->load($inputFileName);
                $sheetData = $spreadsheet->getActiveSheet()->toArray();

                $startRow = 1;
                $data = [];
                for ($i = $startRow; $i < count($sheetData); $i++) {
                    $id = $sheetData[$i]['0'];
                    $name = $sheetData[$i]['1'];
                    $active = $sheetData[$i]['2'];
                    $description = $sheetData[$i]['3'];
                    $row = [
                        'id' => $id,
                        'name' => $name,
                        'isactive' => $active,
                        'description' => $description
                    ];
                    array_push($data, $row);
                }

                Category::insert($data);
            }
        }

        return redirect()->back()->with(['success' => 'Import Successed.']);
    }
}
