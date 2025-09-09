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
        Schema::create('courier_aggregators', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g. Shiprocket, etc.
            $table->string('account_name')->nullable(); // useful if you have multiple accounts
            $table->string('api_key')->nullable();
            $table->string('api_secret')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courier_aggregators');
    }
};
