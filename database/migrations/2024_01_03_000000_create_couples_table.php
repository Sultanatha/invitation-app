<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('couples', function (Blueprint $table) {
            $table->id();
            $table->enum('role', ['groom', 'bride']);
            $table->string('full_name');
            $table->string('nickname')->nullable();
            $table->string('child_order')->nullable(); // contoh: "Anak ke-1 dari 2 bersaudara"
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->text('bio')->nullable();
            $table->string('photo')->nullable();
            $table->string('instagram')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('couples');
    }
};
