<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFichastecnicasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fichastecnicas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('produto1_id')->unsigned();
            $table->foreign('produto1_id')->references('id')->on('produtos');
            $table->integer('produto2_id')->unsigned();
            $table->foreign('produto2_id')->references('id')->on('produtos');
            $table->unique(['produto1_id', 'produto2_id']);
            $table->double('quantidade');
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
        Schema::drop('fichastecnicas');
    }
}
