<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('emprendedores', function (Blueprint $table) {
            $table->string('slug_emprendimiento', 200)->unique()->nullable()->after('nombre_emprendimiento');
            $table->string('descripcion_emprendimiento', 255)->nullable()->after('slug_emprendimiento');
            $table->string('foto_perfil')->nullable()->after('video_url');
            $table->string('foto_portada')->nullable()->after('foto_perfil');
            $table->decimal('latitud', 10, 8)->nullable()->after('foto_portada');
            $table->decimal('longitud', 11, 8)->nullable()->after('latitud');
            $table->integer('id_admin_validador')->nullable()->after('fecha_solicitud');
            $table->text('comentario_rechazo')->nullable()->after('id_admin_validador');
            $table->boolean('verificado')->default(0)->after('comentario_rechazo');
            $table->string('ubicacion', 150)->nullable()->after('verificado');
            $table->timestamp('fecha_validacion')->nullable()->after('ubicacion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('emprendedores', function (Blueprint $table) {
            $table->dropColumn([
                'slug_emprendimiento',
                'descripcion_emprendimiento',
                'foto_perfil',
                'foto_portada',
                'latitud',
                'longitud',
                'id_admin_validador',
                'comentario_rechazo',
                'verificado',
                'ubicacion',
                'fecha_validacion'
            ]);
        });
    }
};
