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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', [\App\Enums\Roles::EXECUTOR->name, \App\Enums\Roles::CUSTOMER->name]);
            $table->tinyInteger('rating')->default(0);
            $table->binary('avatar')->nullable();
            $table->date('birthday')->nullable();
            $table->string('phone')->nullable();
            $table->string('telegram')->nullable();
            $table->text('about')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropColumns('users', [
            'role',
            'rating',
            'avatar',
            'birthday',
            'phone',
            'telegram',
            'about'
        ]);
    }
};
