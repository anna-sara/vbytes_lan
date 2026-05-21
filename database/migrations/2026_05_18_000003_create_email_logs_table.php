<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('email_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('participant_id')->constrained()->cascadeOnDelete();
            $table->integer('lan_id')->nullable();
            $table->string('guardian_email')->nullable();
            $table->foreignId('mailtemplate_id')->nullable()->constrained('mailtemplates')->nullOnDelete();
            $table->foreignId('smstemplate_id')->nullable()->constrained('smstemplates')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('email_logs');
    }
};
