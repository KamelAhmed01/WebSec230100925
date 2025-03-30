<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            // (Optional) Specify engine, charset, and collation:
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';

            // Primary key
            $table->bigIncrements('id');

            // Columns from your screenshot
            $table->string('code', 64);
            $table->string('name', 256);
            $table->integer('price');
            $table->integer('stock')->default(0);
            $table->string('model', 128);
            $table->text('description')->nullable();
            $table->string('photo', 128)->nullable();

            // Timestamps (created_at, updated_at)
            $table->timestamps();

            // Soft deletes (deleted_at)
            $table->softDeletes();
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
