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
            'first_name' => 'Bond',
            'last_name' => 'Burton',
            'name' => 'Bond',
            'role' => 'super_admin',
            'phone_number' => '0834464043',
            'avatar' => 'https://profile.line-scdn.net/0hGgJ_7Pf5GEhnJgraJclmNxd2GyJEV0FaSUNXfFMmQy9dHlxJGEUCfFJ1RX5fE1hKHkJVKQciQXhrNW8ueXDkfGAWRXlbF1gdTEFXqQ',
            'is_verified' => true,
            'verified_at' => now(),
        ]);

        AuthProvider::create([
            'user_id' => $user->id,
            'provider_id' => 'U735fb461941383eb14f9ff9e24c5f8fb',
            'provider' => 'line'
        ]);
    }
}
