<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('producto', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('nombre');
            $table->integer('categoria_id');
            $table->integer('precio');
            $table->integer('stock');
            $table->text('descripcion');
            $table->integer('estado_id');
            $table->integer('estado')->default(0);
            $table->integer('cant_minimo')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('producto');
    }
};
