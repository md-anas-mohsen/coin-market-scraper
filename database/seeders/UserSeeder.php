<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin_user = new User();
        $admin_user->name = 'admin';
        $admin_user->email = 'admin@mailinator.com';
        $admin_user->password = bcrypt('admin123');
        $admin_user->role = 'ADMIN';
        $admin_user->email_verified_at = now();
        $admin_user->save();
    }
}
