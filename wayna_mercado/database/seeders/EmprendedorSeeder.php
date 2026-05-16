<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Emprendedor;

class EmprendedorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear un usuario de prueba
        $usuario = User::firstOrCreate(
            ['email' => 'emprendedor@wayna.com'],
            [
                'name' => 'Cristian',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );

        // Crear un emprendedor de prueba
        Emprendedor::firstOrCreate(
            ['id_usuario' => $usuario->id_usuario],
            [
                'nombre_emprendimiento' => 'Artesanías del Valle Andino',
                'slug_emprendimiento' => 'artesanias-valle-andino',
                'descripcion_emprendimiento' => 'Somos una pequeña empresa dedicada a la producción de artesanías tradicionales andinas. Nuestros productos están hechos con técnicas ancestrales y materiales sostenibles. Cada pieza es única y cuenta la historia de nuestra cultura.',
                'biografia' => 'Mi nombre es Cristian y soy un apasionado por la preservación de las tradiciones andinas. Comencé este emprendimiento hace 5 años con el sueño de llevar las artesanías tradicionales a nuevos mercados. Cada día trabajo para mantener viva la cultura de nuestros antepasados mientras genero oportunidades de empleo en mi comunidad.',
                'frase_impacto' => '"Preservando tradiciones, creando futuro"',
                'video_url' => 'https://www.youtube.com/embed/jNQXAC9IVRw',
                'foto_perfil' => 'https://i.pravatar.cc/150?img=12',
                'foto_portada' => 'https://images.unsplash.com/photo-1452587925148-ce544e77e70d?w=1200&h=300&fit=crop',
                'categoria' => 'artesania',
                'ubicacion' => 'La Paz, Bolivia',
                'latitud' => -16.5000,
                'longitud' => -68.1500,
                'estado_validacion' => 'aprobado',
                'verificado' => 1,
            ]
        );

        $this->command->info('Emprendedor de prueba creado correctamente.');
        $this->command->info('Email: emprendedor@wayna.com');
        $this->command->info('Contraseña: password');
    }
}
