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
        Schema::create('produtos', function(Blueprint $table) {
            $table->id();
            $table->string('produto');
            $table->string('descricao');
            $table->string('codigo')->unique();
            $table->boolean('em_estoque')->default(true);
            $table->boolean('ativo')->default(true);
            $table->integer('usuario_id_inclusao');
            $table->integer('usuario_id_alteracao')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produtos');
    }
};
