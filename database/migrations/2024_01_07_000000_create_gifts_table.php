<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gifts', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['bank', 'ewallet', 'address']);
            $table->string('provider_name'); // BCA, GoPay, dst
            $table->string('account_number')->nullable();
            $table->string('account_name')->nullable();
            $table->text('note')->nullable();
            $table->string('logo')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gifts');
    }
};
