<?php
// database/migrations/xxxx_create_emprendedores_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('emprendedores', function (Blueprint $table) {
            $table->id('id_emprendedor');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('nombre_emprendimiento', 150);
            $table->text('biografia')->nullable();
            $table->string('frase_impacto', 255)->nullable();
            $table->string('video_url', 255)->nullable();
            $table->enum('categoria', ['gastronomia', 'cosmetica', 'artesania', 'textiles', 'otros'])->default('otros');
            $table->enum('estado_validacion', ['pendiente', 'aprobado', 'rechazado'])->default('pendiente');
            $table->timestamp('fecha_solicitud')->useCurrent();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('emprendedores');
    }
};