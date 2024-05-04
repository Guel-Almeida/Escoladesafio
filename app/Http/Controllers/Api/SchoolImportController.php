<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Imports\SchoolsImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\Response;

class SchoolImportController extends Controller
{
    public function import(Request $request){

        $validator = Validator::make($request->all(), [
            'file' => 'required|file|mimes:xlsx,xls',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'Error', 'message' => $validator->errors()], Response::HTTP_BAD_REQUEST);
        }

        $file = $request->file('file');
        try {
            Excel::import(new SchoolsImport, $file);
            return response()->json(['status'=>'Success','message'=>'File imported successfully'],Response::HTTP_OK);

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['status'=>'Error','message'=>'Ocurring Error'],Response::HTTP_BAD_REQUEST);

        }



    }
}
