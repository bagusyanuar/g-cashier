<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'username' => 'superadmin',
            'password' => Hash::make('@Superadmin123')
        ];
        User::updateOrCreate(
            ['username' => $data['username']],
            $data
        );
    }
}
