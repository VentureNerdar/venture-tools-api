<?php

use App\Enums\AgeGroup;
use App\Enums\Gender;
use App\Models\Contact;
use App\Models\Status;
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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            // $table->foreignIdFor(Status::class, 'contact_status_id');


            $table->boolean('is_active')->default(true);
            $table->string('name', 300)->index();
            $table->string('nickname', 300)->nullable();
            $table->enum('gender', array_column(Gender::cases(), 'value'));
            $table->enum('age', array_column(AgeGroup::cases(), 'value'))->default('26-40 years old');
            $table->dateTime('baptism_date')->nullable();
            $table->string('baptized_by_name', 300)->nullable();

            $table->text('current_prayers')->nullable();
            $table->text('note')->nullable();
            $table->foreignIdFor(User::class, 'assigned_to')->nullable();
            $table->foreignIdFor(Status::class, 'position_id');
            $table->foreignIdFor(Contact::class, 'coached_by')->nullable();
            $table->foreignIdFor(User::class, 'user_profile_id')->nullable();
            $table->foreignIdFor(User::class, 'baptized_by')->nullable();

            $table->foreignIdFor(User::class, 'created_by')->nullable();
            $table->foreignIdFor(User::class, 'updated_by')->nullable();


            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
