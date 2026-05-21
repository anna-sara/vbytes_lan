<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mailtemplates', function (Blueprint $table) {
            $table->foreignId('smstemplate_id')->nullable()->constrained('smstemplates')->nullOnDelete()->after('draft');
        });
    }

    public function down(): void
    {
        Schema::table('mailtemplates', function (Blueprint $table) {
            $table->dropForeignIdFor(\App\Models\Smstemplate::class);
        });
    }
};
