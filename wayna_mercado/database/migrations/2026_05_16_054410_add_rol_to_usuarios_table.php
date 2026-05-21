<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('usuarios', function (Blueprint $table) {
            // Agregar id_rol si no existe
            if (!Schema::hasColumn('usuarios', 'id_rol')) {
                $table->foreignId('id_rol')
                    ->after('id_usuario')
                    ->nullable()
                    ->constrained('roles', 'id_rol')
                    ->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('usuarios', function (Blueprint $table) {
            if (Schema::hasColumn('usuarios', 'id_rol')) {
                $table->dropForeign(['id_rol']);
                $table->dropColumn('id_rol');
            }
        });
    }
};
