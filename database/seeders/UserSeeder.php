<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        User::create([
            'name' => 'System Root',
            'email' => 'root@useinsider.com',
            'password' => Hash::make('password')
        ]);

         User::create([
             'name' => 'Anıl Onay',
             'email' => 'anil@useinsider.com',
             'password' => Hash::make('password')
         ]);
    }
}
