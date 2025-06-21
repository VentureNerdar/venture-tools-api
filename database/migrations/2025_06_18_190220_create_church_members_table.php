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
        Schema::create('church_members', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Church::class, 'church_id');
            $table->foreignIdFor(PeopleGroup::class, 'people_group_id');
            $table->integer('amount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('church_members');
    }
};
