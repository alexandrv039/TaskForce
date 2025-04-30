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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->double('lng')->nullable();
            $table->double('lat')->nullable();
            $table->foreignId('city_id')->nullable()->constrained()->nullOnDelete();
            $table->double('price');
            $table->dateTimeTz('deadline');
            $table->foreignId('customer_id')->constrained('users', 'id')->cascadeOnDelete();
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
