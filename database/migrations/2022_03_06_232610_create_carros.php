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
        Schema::create('carros', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->unsignedBigInteger('user_id');
            $table->string('nome_veiculo');
            $table->string('link');
            $table->string('link_img');
            $table->unsignedDecimal('preco', 14, 2);
            $table->integer('ano');
            $table->integer('quilometragem');
            $table->string('combustivel');
            $table->string('cambio');
            $table->string('portas');
            $table->string('cor');

            $table->primary('id');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('carros');
    }
};
