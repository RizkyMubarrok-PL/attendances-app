<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Classes;
use Illuminate\Database\Seeder;

class ClassesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $programKeahlian = [
            "FKK",
            "MPK",
            "ULW",
            "AKL",
            "DKV",
            "RPL",
            "BD",
        ];
         
        $data = [];

        foreach($programKeahlian as $progli) {
            for ($i = 1; $i <= 3; $i++) {
                $data[] = [
                    'class_name' => "XII-". $progli ."-". $i,
                ];
            }
        }

        Classes::insert($data);
    }
}
