<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
            'name' => 'Administrator',
            'username' => 'admin',
            'email' => 'admin@smkn1ciamis.sch.id',
            'password' => Hash::make('kita ini admin cuy'),
            'role' => 'super_admin',
        ]);

        $this->command->info('Admin berhasil dibuat!');
        $this->command->info('Username: admin');
        $this->command->info('Password: kita ini admin cuy');
    }
}