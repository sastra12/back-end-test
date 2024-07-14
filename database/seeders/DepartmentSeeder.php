<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('departments')->insert([
            'name' => 'Departemen Keuangan',
        ]);
        DB::table('departments')->insert([
            'name' => 'Departemen Sumber Daya Manusia',
        ]);
        DB::table('departments')->insert([
            'name' => 'Departemen TI',
        ]);
        DB::table('departments')->insert([
            'name' => 'Departemen Administrasi',
        ]);
        DB::table('departments')->insert([
            'name' => 'Departemen Produksi',
        ]);
    }
}
