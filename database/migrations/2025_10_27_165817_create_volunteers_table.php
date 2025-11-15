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
        Schema::create('volunteers', function (Blueprint $table) {
          $table->id();
            $table->integer('lan_id')->nullable();
            $table->string('first_name');
            $table->string('surname');
            $table->string('phone');
            $table->string('email');
            $table->boolean('gdpr')->default(false);
            $table->json('areas');
            $table->boolean('emailed')->default(false);
            $table->string('comment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('volunteers');
    }
};
