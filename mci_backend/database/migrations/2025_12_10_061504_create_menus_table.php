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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->string('url')->nullable(); // external or manual URL
            $table->foreignId('page_id')->nullable()->constrained()->nullOnDelete(); // link to pages table
            $table->integer('order')->default(0);
            $table->foreignId('parent_id')->nullable(); // for nested menus

    // header, footer, sidebar, etc.
    $table->string('location')->default('header');

    $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
