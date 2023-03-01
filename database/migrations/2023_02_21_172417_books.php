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
        Schema::create('books', function(Blueprint $table){
            $table->integer('id')->autoIncrement();
            $table->string('isbn')->unique();
            $table->string('title');
            $table->string('author');
            $table->date('published_date');
            $table->string('description');
            $table->decimal('price')->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
