<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateTestUser extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'user:create-test {--role=2}';

    /**
     * The console command description.
     */
    protected $description = 'Crea un usuario de prueba. (role: 1=admin, 2=emprendedor, 3=cliente)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $role = $this->option('role');
        
        $roles = [
            1 => 'Admin',
            2 => 'Emprendedor',
            3 => 'Cliente'
        ];

        if (!isset($roles[$role])) {
            $this->error("Rol inválido. Usa: 1 (admin), 2 (emprendedor), 3 (cliente)");
            return 1;
        }

        $user = User::create([
            'nombre' => 'Test ' . $roles[$role],
            'apellido' => 'Usuario',
            'email' => strtolower($roles[$role]) . '@test.com',
            'password' => Hash::make('password123'),
            'telefono' => '123456789',
            'id_rol' => $role,
            'estado' => 'activo'
        ]);

        $this->info("✅ Usuario de prueba creado exitosamente!");
        $this->table(
            ['Email', 'Contraseña', 'Rol'],
            [
                [$user->email, 'password123', $roles[$role]]
            ]
        );

        return 0;
    }
}
