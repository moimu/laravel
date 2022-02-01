<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartaMagicsTable extends Migration
{
    // HACER LA CLASE
    // titulo como   string obligatorio
    // tipo como     string obligatorio
    // email_creador string opcional
    // imagen        string opcional
    // descripcion   texto mas largo (opcional)
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carta_magics', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            // añadimos un foreing key referenciado con id table users
            $table->foreignId('user_id')->references('id')->on('users');
            $table->string('titulo');
            $table->string('tipo');
            $table->string('email_creador')->nullable();
            $table->string('imagen')->nullable();
            $table->LongText('descripcion')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('carta_magics');
    }
}
