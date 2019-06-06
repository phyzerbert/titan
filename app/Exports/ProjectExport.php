<?php

namespace App\Exports;

use App\Models\Project;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class ProjectExport implements FromArray, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function array(): array
    {
        $data = DB::table('projects')
                ->join('companies', 'projects.company_id', '=', 'companies.id')
                ->join('users', 'projects.user_id', '=', 'users.id')
                ->select('projects.id','projects.name', 'projects.description', 'users.name as username', 'companies.name as companyname', 'projects.due_to', 'projects.progress', 'projects.limit', 'projects.created_at')
                ->get()->toArray();
        foreach ($data as $key => $value) {
            $project = Project::find($value->id);
            $value->progress = $project->courses->avg('progress');
        }
        return $data;
    }

    public function headings(): array
    {
        return [
            'No',
            'Name',
            'Description',
            'User',
            'Company',
            'Due Date',
            'Progress',
            'Money Limit',
            'Created Date',
        ];
    }
}
