<?php

use App\Models\Church;
use App\Models\PeopleGroup;
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
        Schema::create('church_people_group', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Church::class);
            $table->foreignIdFor(PeopleGroup::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('church_people_group');
    }
};
