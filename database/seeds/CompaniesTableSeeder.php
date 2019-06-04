<?php

use Illuminate\Database\Seeder;
use App\Models\Company;

class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Company::create(['name' => 'Company1']);
        Company::create(['name' => 'Company2']);
        Company::create(['name' => 'Company3']);
        Company::create(['name' => 'Company4']);
    }
}
