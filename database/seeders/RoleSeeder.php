<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $super_admin = new Role;
        $super_admin->name = 'Super Admin';
        $super_admin->save();

        $admin = new Role;
        $admin->name = 'Admin';
        $admin->save();

        $operations = new Role;
        $operations->name = 'Operations';
        $operations->save();

        $customer_care = new Role;
        $customer_care->name = 'Customer Care';
        $customer_care->save();

        $vendor = new Role;
        $vendor->name = 'Vendor';
        $vendor->save();

        $customer = new Role;
        $customer->name = 'Customer';
        $customer->save();
    }
}
