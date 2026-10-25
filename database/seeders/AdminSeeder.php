<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $isProduction = app()->environment('production');

        // 1. Akun Administrator Utama
        $adminConfig   = config('auth.seed_admin', []);
        $adminUsername = $adminConfig['username'] ?? env('ADMIN_USERNAME', 'admin');
        $adminName     = $adminConfig['name'] ?? env('ADMIN_NAME', 'Admin Ar-Raudhah');
        $adminEmail    = $adminConfig['email'] ?? env('ADMIN_EMAIL', $adminUsername . '@arraudhah.id');
        $adminPassword = $adminConfig['password'] ?? env('ADMIN_PASSWORD', 'Admin_ArRaudhah#2026');

        $admin = User::where('username', $adminUsername)
            ->orWhere('email', $adminEmail)
            ->first();

        if (!$admin) {
            // Jika akun admin baru dan password belum ditentukan di env
            if (empty($adminPassword)) {
                $adminPassword = $isProduction ? Str::random(20) : 'Admin_ArRaudhah#2026';
                if ($this->command) {
                    $this->command->warn("ADMIN_PASSWORD tidak ditemukan di environment. Password sementara dibuat: {$adminPassword}");
                }
            }

            User::create([
                'name'     => $adminName,
                'username' => $adminUsername,
                'email'    => $adminEmail,
                'role'     => 'Administrator',
                'password' => Hash::make($adminPassword),
            ]);

            $this->command?->info("Akun Administrator [{$adminUsername}] berhasil dibuat.");
        } else {
            // Akun admin sudah ada di sistem
            $admin->name     = $adminName ?: $admin->name;
            $admin->username = $adminUsername;
            $admin->email    = $adminEmail ?: $admin->email;
            $admin->role     = 'Administrator';

            // Cegah overwrite password pengguna lama, kecuali eksplisit diizinkan
            if (env('ADMIN_FORCE_RESET_PASSWORD', false) && !empty($adminPassword)) {
                $admin->password = Hash::make($adminPassword);
                $this->command?->info("Password Administrator [{$adminUsername}] direset sesuai environment.");
            }

            $admin->save();
            $this->command?->info("Akun Administrator [{$adminUsername}] sudah terdaftar (password tidak diubah).");
        }

        // 2. Akun Contoh Penguji TPQ & RTQ (hanya disemai di dev/staging atau jika disetujui di production)
        $seedSampleUsers = !$isProduction || env('SEED_SAMPLE_USERS', false);

        if ($seedSampleUsers) {
            $this->seedPenguji(
                role: 'Penguji TPQ',
                configKey: 'seed_penguji_tpq',
                defaultUsername: 'penguji_tpq',
                defaultName: 'Ustadz Ahmad Al-Hafidz',
                defaultEmail: 'ahmad@arraudhah.id',
                defaultPassword: $isProduction ? null : 'Penguji_TPQ#2026',
                envUserKey: 'PENGUJI_TPQ_USERNAME',
                envPassKey: 'PENGUJI_TPQ_PASSWORD'
            );

            $this->seedPenguji(
                role: 'Penguji RTQ',
                configKey: 'seed_penguji_rtq',
                defaultUsername: 'penguji_rtq',
                defaultName: 'Ustadzah Fatimah Az-Zahra',
                defaultEmail: 'fatimah@arraudhah.id',
                defaultPassword: $isProduction ? null : 'Penguji_RTQ#2026',
                envUserKey: 'PENGUJI_RTQ_USERNAME',
                envPassKey: 'PENGUJI_RTQ_PASSWORD'
            );
        }
    }

    /**
     * Helper untuk membuat atau memperbarui akun penguji dengan aman.
     */
    protected function seedPenguji(
        string $role,
        string $configKey,
        string $defaultUsername,
        string $defaultName,
        string $defaultEmail,
        ?string $defaultPassword,
        string $envUserKey,
        string $envPassKey
    ): void {
        $config   = config("auth.{$configKey}", []);
        $username = $config['username'] ?? env($envUserKey, $defaultUsername);
        $name     = $config['name'] ?? $defaultName;
        $email    = $config['email'] ?? $defaultEmail;
        $password = $config['password'] ?? env($envPassKey, $defaultPassword);

        // Di production jika tidak ada password yang disetel di env, lewati pembuatan akun contoh
        if (empty($password)) {
            return;
        }

        $user = User::where('username', $username)
            ->orWhere('email', $email)
            ->first();

        if (!$user) {
            User::create([
                'name'     => $name,
                'username' => $username,
                'email'    => $email,
                'role'     => $role,
                'password' => Hash::make($password),
            ]);
            $this->command?->info("Akun {$role} [{$username}] berhasil disiapkan.");
        } else {
            $user->name = $name ?: $user->name;
            $user->role = $role;
            if (env('ADMIN_FORCE_RESET_PASSWORD', false)) {
                $user->password = Hash::make($password);
            }
            $user->save();
        }
    }
}
