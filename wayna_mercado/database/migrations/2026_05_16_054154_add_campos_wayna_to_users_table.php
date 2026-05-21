<?php
// database/migrations/xxxx_add_campos_wayna_to_users_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('usuarios', function (Blueprint $table) {
            $table->string('apellido', 100)->nullable()->after('nombre');
            $table->string('telefono', 30)->nullable()->after('email');
            $table->integer('id_rol')->default(3)->after('telefono'); // 1=Admin, 2=Emprendedor, 3=Cliente
            $table->enum('estado', ['activo', 'inactivo'])->default('activo')->after('id_rol');
        });
    }

    public function down()
    {
        Schema::table('usuarios', function (Blueprint $table) {
            $table->dropColumn(['apellido', 'telefono', 'id_rol', 'estado']);
        });
    }
};