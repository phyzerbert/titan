<?php

namespace App\Exports;

use App\Models\Project;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class ProjectExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = DB::table('projects')
                ->join('companies', 'projects.company_id', '=', 'companies.id')
                ->join('users', 'projects.user_id', '=', 'users.id')
                ->select('projects.name', 'projects.description', 'users.name as username', 'companies.name as companyname', 'projects.due_to', 'projects.limit', 'projects.progress', 'projects.created_at')
                ->get();
        return $data;
    }

    public function headings(): array
    {
        return [
            'Name',
            'Description',
            'User',
            'Company',
            'Due Date',
            'Money Limit',
            'Progress',
            'Created Date',
        ];
    }
}
