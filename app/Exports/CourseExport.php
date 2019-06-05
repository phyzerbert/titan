<?php

namespace App\Exports;

use App\Models\Course;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class CourseExport implements FromArray, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $project_id;

    public function __construct($id)
    {
        $this->project_id = $id;
    }

    public function array(): array
    {
        $status = array('New', 'In Progress', 'On Hold', 'Completed');
        $data = DB::table('courses')
                ->join('projects', 'courses.project_id', '=', 'projects.id')
                ->select('courses.name', 'courses.description', 'projects.name as projectname', 'courses.due_to', 'courses.status', 'courses.created_at')
                ->where('courses.project_id', $this->project_id)
                ->get()->toArray();
        foreach ($data as $key => $value) {
            $value->status = $status[$value->status];
        }

        return $data;
    }

    public function headings(): array
    {
        return [
            'Name',
            'Description',
            'Project',
            'Due Date',
            'Status',
            'Created at',
        ];
    }
}
