<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('employees')->insert([
            'name' => Str::random(10),
            'phone_number' => '083166078912',
            'date_of_birth' => '1995-07-29',
            'date_of_joining' => '2024-06-29',
            'address' => 'Jakarta',
            'gender' => 'MAN',
            'department_id' => 1,
        ]);
        DB::table('employees')->insert([
            'name' => Str::random(10),
            'phone_number' => '083144078912',
            'date_of_birth' => '1990-01-29',
            'date_of_joining' => '2022-06-29',
            'address' => 'Jakarta',
            'gender' => 'WOMAN',
            'department_id' => 1,
        ]);
        DB::table('employees')->insert([
            'name' => Str::random(10),
            'phone_number' => '0877166078988',
            'date_of_birth' => '1997-01-01',
            'date_of_joining' => '2024-07-20',
            'address' => 'Jakarta',
            'gender' => 'WOMAN',
            'department_id' => 2,
        ]);
        DB::table('employees')->insert([
            'name' => Str::random(10),
            'phone_number' => '082166098912',
            'date_of_birth' => '2004-07-29',
            'date_of_joining' => '2023-06-29',
            'address' => 'Jakarta',
            'gender' => 'MAN',
            'department_id' => 3,
        ]);
        DB::table('employees')->insert([
            'name' => Str::random(10),
            'phone_number' => '082166078910',
            'date_of_birth' => '1995-12-29',
            'date_of_joining' => '2024-01-29',
            'address' => 'Jakarta',
            'gender' => 'MAN',
            'department_id' => 4,
        ]);
        DB::table('employees')->insert([
            'name' => Str::random(10),
            'phone_number' => '0877166078912',
            'date_of_birth' => '1995-07-29',
            'date_of_joining' => '2024-06-29',
            'address' => 'Jakarta',
            'gender' => 'WOMAN',
            'department_id' => 5,
        ]);
    }
}
