<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Default admin panel account
        $admin = new Admin;
        $admin->email = 'skkarwasra02@gmail.com';
        $admin->password = Hash::make('password');
        $admin->save();
    }
}
