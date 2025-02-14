<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // id produk
            $table->string('name'); // nama produk
            $table->text('description')->nullable(); // deskripsi produk
            $table->decimal('price', 10, 2); // harga produk
            $table->integer('stock'); // jumlah stok produk
            $table->boolean('is_active')->default(true); // status aktif produk
            $table->timestamps(); // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
