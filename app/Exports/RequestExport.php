<?php

namespace App\Exports;

use App\Models\Request;
use App\Models\Company;
use App\Models\Project;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class RequestExport implements FromArray, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function array(): array
    {
        // return Request::select('title', 'description', 'user_id', 'course_id', 'amount', 'created_at', 'status')
        //                 ->orderBy('created_at', 'desc')->get();
        $status = array('Pending', 'Rejected', 'Approved');
        $data = DB::table('requests')
                ->join('courses', 'requests.course_id', '=', 'courses.id')
                ->join('users', 'requests.user_id', '=', 'users.id')
                ->join('projects', 'courses.project_id', '=', 'projects.id')
                ->select('requests.title', 'requests.description', 'users.name as username', 'projects.name as proejectname', 'courses.name as coursename', 'requests.amount', 'requests.note', 'requests.created_at', 'requests.status')
                ->get()->toArray();
        
        foreach ($data as $key => $value) {
            // $project = Project::find($value->project_id);
            $value->status = $status[$value->status];
        }
        // dump($data); die;
        return $data;
    }

    public function headings(): array
    {
        return [
            'Title',
            'Description',
            'User',
            'Project',
            'Course',
            'Amount',
            'Note',
            'Request Date',
            'Status',
        ];
    }
}
