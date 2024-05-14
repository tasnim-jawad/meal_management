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
         Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200);
            $table->bigInteger('role_id')->nullable()->default(4);
            $table->string('image', 50)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('password', 60);
            $table->string('mobile', 20)->nullable();
            $table->string('Whatsapp', 20)->nullable();
            $table->string('Telegram', 20)->nullable();
            $table->enum('department', ["IT", "IELTS", "Spoken", "Employee"]);
            $table->bigInteger('batch_id', 20)->nullable();
            $table->string('address', 100);
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
