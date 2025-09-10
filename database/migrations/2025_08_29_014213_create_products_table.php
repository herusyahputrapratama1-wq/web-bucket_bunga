<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   
// database/migrations/xxxx_create_products_table.php
public function up(): void
{
    Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->foreignId('category_id')->constrained()->onDelete('cascade'); // Terhubung ke tabel categories
        $table->string('name'); // Nama produk
        $table->string('slug')->unique(); // URL-friendly
        $table->text('description')->nullable(); // Deskripsi produk
        $table->integer('price'); // Harga produk
        $table->integer('stock'); // Jumlah stok
        $table->string('image')->nullable(); // Path/nama file gambar produk
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};