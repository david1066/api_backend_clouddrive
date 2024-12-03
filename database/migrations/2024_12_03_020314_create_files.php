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
         Schema::create('files', function (Blueprint $table) { 
            $table->id(); 
            $table->string('name'); 
            $table->string('s3_name'); 
            $table->unsignedBigInteger('user_id'); // Añadir columna de llave foránea 
            $table->timestamps(); 
            $table->softDeletes(); // Añadir columna deleted_at para Soft Deletes // Definir la llave foránea 
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};
