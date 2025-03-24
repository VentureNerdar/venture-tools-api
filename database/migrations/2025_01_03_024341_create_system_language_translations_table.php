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
        Schema::create('system_language_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\SystemLanguage::class);
            $table->foreignIdFor(\App\Models\SystemLanguageWord::class);
            $table->text('translation');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_language_translations');
    }
};
