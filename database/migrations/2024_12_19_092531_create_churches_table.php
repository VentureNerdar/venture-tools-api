<?php

use App\Models\Church;
use App\Models\Community;
use App\Models\Denomination;
use App\Models\User;
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
        Schema::create('churches', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_active')->default(true);
            $table->foreignIdFor(User::class, 'assigned_to')->nullable();
            $table->foreignIdFor(Community::class);

            $table->string('name', 300)->index();
            $table->text('description')->nullable();
            $table->date('founded_at')->nullable();
            $table->string('phone_number', 300)->nullable();
            $table->string('website', 300)->nullable();
            $table->foreignIdFor(Denomination::class, 'denomination_id')->nullable();
            $table->boolean('is_visited')->default(false);

            $table->integer('church_members_count')->nullable();
            $table->integer('confession_of_faith_count')->nullable();
            $table->integer('baptism_count')->nullable();

            $table->foreignIdFor(Church::class, 'parent_church_id')->nullable();
            $table->text('current_prayers')->nullable();

            // Note : Need to add address location

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('churches');
    }
};
