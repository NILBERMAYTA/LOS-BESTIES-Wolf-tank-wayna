<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class TestUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $email = 'test_user_autogen@example.com';

        // Avoid duplicating if already exists
        if (User::where('email', $email)->exists()) {
            $this->command->info("Test user already exists: {$email}");
            return;
        }

        $user = User::create([
            'nombre' => 'test_user_autogen',
            'apellido' => 'User',
            'email' => $email,
            'password' => bcrypt('Secret123!'),
            'telefono' => '0000000000',
            'id_rol' => 3,
            'estado' => 'activo',
        ]);

        $id = $user->id_usuario ?? $user->id ?? 'unknown';
        $this->command->info("Created test user: {$email} (id: {$id})");
    }
}
