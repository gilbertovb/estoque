<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstoqueProdutoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estoque_produto', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('estoque_id')->unsigned();
            $table->foreign('estoque_id')->references('id')->on('estoques');
            $table->integer('produto_id')->unsigned();
            $table->foreign('produto_id')->references('id')->on('produtos');
            $table->double('min')->nullable();
            $table->double('atual');
            $table->unique(['estoque_id', 'produto_id']);
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
        Schema::drop('estoque_produto');
    }
}
