<?php

namespace App\Http\Controllers;

use App\Exports\CleanedDataExport;
use App\Services\UtilityService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    public function __construct(private UtilityService $utilServices) { }

    public function form()
    {
        return view('pages.dashboard',[
            'title' => 'Dashboard',
            'breadcrumb' => (object) [
                'parents' => [['url' => route('excel.form'), 'title' => 'Admin']],
                'current' => 'Dashboard'
            ]
        ]);
    }

    public function upload(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,csv,xls',
        ]);

        $data = Excel::toArray([], $request->file('excel_file'))[0];
        if (count($data) < 1) {
            return back()->with('error', 'Data tidak cukup');
        }

        $prepocessedData = $this->utilServices->cleaningData($data);
        $transitionCount = $this->utilServices->countTransition($prepocessedData);

        return response()->json(['data' => $transitionCount]);
    }

    public function download(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,csv,xls',
        ]);

        $file = $request->file('excel_file');
        $filename = sprintf('cleaned_%s',$file->getClientOriginalName());
        $data = Excel::toArray([], $request->file('excel_file'))[0];
        if (count($data) < 1) {
            return back()->with('error', 'Data tidak cukup');
        }

        $prepocessedData = $this->utilServices->cleaningData($data);
        // $transitionCount = $this->utilServices->countTransition($prepocessedData);

        // return response()->json(['data' => $transitionCount]);
        return Excel::download(new CleanedDataExport($prepocessedData), $filename);
        // return view('result', ['data' => $data]); 
    }

    public function getCleaned()
    {
        return view('upload');
    }
}
