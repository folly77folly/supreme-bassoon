<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\State;


class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
	 * 
     *
     * @return void
     */
    public function run()
    {

        // DB::table('states')->delete();
		$states = array(
			array('name' => "Abia"),
			array('name' => "Abuja Federal Capital Territor"),
			array('name' => "Adamawa"),
			array('name' => "Akwa Ibom"),
			array('name' => "Anambra"),
			array('name' => "Bauchi",),
			array('name' => "Bayelsa"),
			array('name' => "Benue"),
			array('name' => "Borno"),
			array('name' => "Cross River"),
			array('name' => "Delta"),
			array('name' => "Ebonyi"),
			array('name' => "Edo"),
			array('name' => "Ekiti"),
			array('name' => "Enugu"),
			array('name' => "Gombe"),
			array('name' => "Imo"),
			array('name' => "Jigawa"),
			array('name' => "Kaduna"),
			array('name' => "Kano"),
			array('name' => "Katsina"),
			array('name' => "Kebbi"),
			array('name' => "Kogi"),
			array('name' => "Kwara"),
			array('name' => "Lagos"),
			array('name' => "Nassarawa"),
			array('name' => "Niger"),
			array('name' => "Ogun"),
			array('name' => "Ondo"),
			array('name' => "Osun"),
			array('name' => "Oyo"),
			array('name' => "Plateau"),
			array('name' => "Rivers"),
			array('name' => "Sokoto"),
			array('name' => "Taraba"),
			array('name' => "Yobe"),
			array('name' => "Zamfara"),
		);
		DB::table('states')->insert($states);
    }
}
