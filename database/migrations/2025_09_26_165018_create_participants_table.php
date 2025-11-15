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
        Schema::create('participants', function (Blueprint $table) {
            $table->id();
            $table->integer('lan_id')->nullable();
            $table->boolean('member');
            $table->string('first_name');
            $table->string('surname');
            $table->string('grade');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('guardian_name');
            $table->string('guardian_phone');
            $table->string('guardian_email');
            $table->boolean('is_visiting')->default(false);
            $table->boolean('gdpr')->default(false);
            $table->string('friends')->nullable();
            $table->string('special_diet')->nullable();
            $table->string('status')->nullable();
            $table->boolean('paid')->default(false);
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
        Schema::dropIfExists('participants');
    }
};
