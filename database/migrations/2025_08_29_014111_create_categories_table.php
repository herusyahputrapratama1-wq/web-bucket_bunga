<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   // database/migrations/xxxx_create_categories_table.php
public function up(): void
{
    Schema::create('categories', function (Blueprint $table) {
        $table->id(); // Kolom ID unik (Primary Key)
        $table->string('name'); // Nama kategori, misal: "Buket Pernikahan"
        $table->string('slug')->unique(); // URL-friendly, misal: "buket-pernikahan"
        $table->timestamps(); // Kolom created_at dan updated_at
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};