<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Request as MoneyRequest;
use App\Exports\RequestExport;
use App\Exports\ProjectExport;
use App\Exports\CourseExport;
use Excel;

class ExcelController extends Controller
{
    public function export_request(Request $request){
        $cdt = date('Y-m-d H:i:s');
        return Excel::download(new RequestExport, "Requests($cdt).xlsx");;
    }

    public function export_project(Request $request){
        $cdt = date('Y-m-d H:i:s');
        return Excel::download(new ProjectExport, "Projects($cdt).xlsx");;
    }

    public function export_course(Request $request, $id){
        $cdt = date('Y-m-d H:i:s');
        return Excel::download(new CourseExport($id), "Courses($cdt).xlsx");;
    }
}
