<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use App\Models\Tefa;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::updateOrCreate([
            'username' => 'superadmin',
        ], [
            'name' => 'SuperAdmin',
            'email' => 'admin@smkn1ciamis.sch.id',
            'password' => Hash::make('kita ini admin cuy'),
            'role' => 'super-admin',
            'tefa_id' => null, // Super admin tidak terikat TEFA tertentu
        ]);

        $tefas = Tefa::query()->orderBy('order')->get();
        $createdAdmins = [];

        foreach ($tefas as $tefa) {
            $normalizedCode = preg_replace('/[^a-z0-9]/', '', Str::lower($tefa->code ?? ''));

            if ($normalizedCode === '') {
                $normalizedCode = preg_replace('/[^a-z0-9]/', '', Str::lower($tefa->name));
            }

            $username = 'admin' . $normalizedCode;
            $plainPassword = $username;

            $adminTefa = Admin::where('role', 'admin-tefa')
                ->where('tefa_id', $tefa->id)
                ->first();

            if (!$adminTefa) {
                $adminTefa = new Admin();
                $adminTefa->role = 'admin-tefa';
                $adminTefa->tefa_id = $tefa->id;
            }

            $adminTefa->name = 'Admin ' . $tefa->name;
            $adminTefa->username = $username;
            $adminTefa->email = $username . '@smkn1ciamis.sch.id';
            $adminTefa->password = Hash::make($plainPassword);
            $adminTefa->save();

            $createdAdmins[] = [
                'tefa' => $tefa->name,
                'username' => $username,
                'password' => $plainPassword,
            ];
        }

        $this->command->info('✅ Super Admin berhasil dibuat!');
        $this->command->info('Username: superadmin');
        $this->command->info('Password: kita ini admin cuy');
        $this->command->info('Role: super-admin');

        if (!empty($createdAdmins)) {
            $this->command->info('✅ Admin TEFA berhasil dibuat: ' . count($createdAdmins) . ' akun');
            foreach ($createdAdmins as $item) {
                $this->command->info("- {$item['tefa']} | username: {$item['username']} | password: {$item['password']}");
            }
        } else {
            $this->command->warn('⚠️ Tidak ada data TEFA. Admin TEFA belum dibuat.');
        }
    }
}
