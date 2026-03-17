<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->integer('external_id')->unique()->index();

            $table->string('title');
            $table->decimal('price',10,2)->index();
            $table->text('description')->nullable();
            $table->string('category')->index();
            $table->string('image')->nullable();

            $table->decimal('rating_rate',3,2)->index();
            $table->integer('rating_count');

            $table->json('update_log')->nullable();

            $table->timestamps();
            $table->softDeletes();
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
