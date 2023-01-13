<?php

namespace Database\Seeders;

use App\Models\User;

use Illuminate\Database\Seeder;

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
            'email' => 'poprev+admin@gmail.com',
            'firstname' => "PopRev",
            'lastname' => "Admin",
            'phone' => "08176157244",
            'role' => 'admin',
            'email_verified_at' => '2023-01-13',
            'password' => bcrypt('admin')
        ]);
    }
}
