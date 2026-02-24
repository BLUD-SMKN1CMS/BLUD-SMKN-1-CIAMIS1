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
            'name' => 'SuperAdmin',
            'username' => 'superadmin',
            'email' => 'admin@smkn1ciamis.sch.id',
            'password' => Hash::make('kita ini admin cuy'),
            'role' => 'super-admin',
            'tefa_id' => null, // Super admin tidak terikat TEFA tertentu
        ]);

        $this->command->info('✅ Super Admin berhasil dibuat!');
        $this->command->info('Username: superadmin');
        $this->command->info('Password: kita ini admin cuy');
        $this->command->info('Role: super-admin');
    }
}
