<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class RoleHasPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::find(1); // data admin
        $user->assignRole('admin');

        $farmer = User::create([
            'name' => 'Farmer',
            'email' => 'farmer@email.test',
            'password' => Hash::make('password')
        ]);
        $farmer->assignRole('farmer');
    }
}
