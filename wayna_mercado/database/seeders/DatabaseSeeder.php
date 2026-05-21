<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
<<<<<<< HEAD
            'name' => 'Test User',
            'email' => 'test@example.com',
=======
            'nombre' => 'Test',
            'apellido' => 'User',
            'email' => 'test@example.com',
            'id_rol' => User::ROLE_CLIENTE,
            'estado' => 'activo',
>>>>>>> origin/feature/leonardo
        ]);
    }
}
