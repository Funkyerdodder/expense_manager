<?php

use Illuminate\Database\Seeder;

use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'username' => 'admin',
            'name' => 'Admin Admin',
            'email' => 'admin@email.com',
            'password' => bcrypt('admin'),
            'role_id' => 2
        ]);

        User::create([
            'username' => 'user',
            'name' => 'John Doe',
            'email' => 'user@email.com',
            'password' => bcrypt('user'),
            'role_id' => 1
        ]);
    }
}
