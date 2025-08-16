<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash; 
use Illuminate\Support\Str;

class AdmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'id' => Str::uuid(),
                'name' => 'Administração FADAT',
                'email' => 'cti@fadat.edu.br',
                'password' => Hash::make('GGwn004a0£Ql'),
                'access_level' => '99',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
