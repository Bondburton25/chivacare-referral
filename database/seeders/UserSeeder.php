<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\{
    AuthProvider,
    User
};

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'first_name' => '🍀🍁PakEY😻แพก🎶',
            'name' => '🍀🍁PakEY😻แพก🎶',
            'last_name' => 'แพกกี้',
            'role' => 'admin',
            'phone_number' => '0619628165',
            'avatar' => 'https://profile.line-scdn.net/0hMeKZ_xk1EkpmIzipxXNsNRZzESBFUktYTkZeKQAqTS5fGwdITk1YfwN2TXoMEFAcT0BbKlogS3pqMGUseHXufmETT3taElIfTURdqw',
            'is_verified' => true,
            'verified_at' => now(),
        ]);

        AuthProvider::create([
            'user_id' => $user->id,
            'provider_id' => 'Uda966d3629f63b8d8cd4ba2a4990832c',
            'provider' => 'line'
        ]);
    }
}
