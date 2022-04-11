<?php

namespace Database\Seeders;

use App\Models\Gender;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class GenderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $female = new Gender;
        $female->name = 'female';
        $female->save();

        $male = new Gender;
        $male->name = 'male';
        $male->save();
    }
}
