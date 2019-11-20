<?php

use Illuminate\Database\Seeder;
use App\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'User',
            'description' => 'User Access',
            'access' => 'user'
        ]);
        Role::create([
            'name' => 'Admin',
            'description' => 'Admin Access',
            'access' => 'admin'
        ]);
    }
}
