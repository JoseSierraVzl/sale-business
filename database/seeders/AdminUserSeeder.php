<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $password = '12345';
        $user = new User([
            'name' => 'admin',
            'email' => 'superAdmin@gmail.com',
            'password' => Hash::make($password),
            'role' => 'admin'
        ]);
        $user->saveOrFail();
    }
}
