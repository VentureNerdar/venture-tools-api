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
        Schema::create('community_peace_persons', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Community::class);
            $table->string('name', 500)->index();
            $table->string('email', 300)->nullable();
            $table->string('phone', 20)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('community_peace_persons');
    }
};
