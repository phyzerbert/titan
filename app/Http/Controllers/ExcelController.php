<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Request as MoneyRequest;
use App\Exports\RequestExport;
use Excel;

class ExcelController extends Controller
{
    public function export_request(Request $request){
        $cdt = date('Y-m-d H:i:s');
        return Excel::download(new RequestExport, "requests($cdt).xlsx");;
    }
}
