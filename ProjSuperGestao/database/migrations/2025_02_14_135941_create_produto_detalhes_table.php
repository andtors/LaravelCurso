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
        Schema::create('produto_detalhes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('produto_id');
            $table->float('comprimento', 8, 2);
            $table->float('largura', 8, 2);
            $table->float('altura', 8, 2);
            $table->timestamps();

            //constraint
            $table->foreign('produto_id')->references('id')->on('produtos');
            $table->unique('produto_id'); //garante que o produto_id seja único na tabela produto_detalhes
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // remover o relacionamento com a tabela produto_detalhes
        Schema::table('produto_detalhes', function (Blueprint $table){
            // remover a foreign key
            $table->dropForeign('produto_detalhes_produto_id_foreign'); //[table]_[coluna]_foreign
            // remover a coluna unidade_id
            $table->dropColumn('produto_id');
        });

        Schema::dropIfExists('produto_detalhes');


    }
};
