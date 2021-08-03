<?php

namespace App\Http\Controllers;

use App\Models\Category;
use FontLib\Table\Type\name;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as XlsxWritter;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as XlsxReader;
use PhpOffice\PhpSpreadsheet\Style\Border;

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
        $sheet->setTitle('CATEGORY DATA');

        $sheet->setCellValue('A1', 'Category Name');
        $sheet->setCellValue('B1', 'Active');
        $sheet->setCellValue('C1', 'Description');
        $sheet->getStyle('A1:C1')->applyFromArray($styleBold);

        $categories = Category::all();
        $cell = 2;
        foreach ($categories as $category) {
            $sheet->setCellValue('A' . $cell, $category->name);
            $sheet->setCellValue('B' . $cell, $category->isactive);
            $sheet->setCellValue('C' . $cell, $category->description);

            $sheet->getStyle('A1' . ':C' . $cell)->applyFromArray($styleBorder);
            $cell++;
        }

        foreach (range('A', 'C') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
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
                    $name = $sheetData[$i]['0'];
                    $active = $sheetData[$i]['1'];
                    $description = $sheetData[$i]['2'];
                    $row = [
                        'name' => $name,
                        'isactive' => $active,
                        'description' => $description
                    ];
                    array_push($data, $row);
                }
            }
        }

        DB::beginTransaction();
        try {
            Category::insert($data);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }

        return redirect()->back()->with(['success' => 'Import Successed.']);
    }
}
