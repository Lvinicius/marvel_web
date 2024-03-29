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
        Schema::create('personagems', function (Blueprint $table) {
            $table->id(); 
            $table->string('nome', 255); 
            $table->string('alcunha', 255); 
            $table->string('foto')->nullable(); 
            $table->string('vinculo', 255); 
            $table->boolean('ativo')->default(true); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personagems');
    }
};
