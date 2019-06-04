<?php

use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => 'Admin', 'slug' => 'admin']);
        Role::create(['name' => 'Accountant', 'slug' => 'accountant']);
        Role::create(['name' => 'Project Manager', 'slug' => 'project_manager']);
        Role::create(['name' => 'Course Member', 'slug' => 'course_member']);
    }
}
