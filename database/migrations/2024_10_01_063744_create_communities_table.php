<?php

use App\Models\District;
use App\Models\Province;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('communities', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_active')->default(true);

            $table->string('name', 500)->index();
            $table->decimal('location_longitude', 10, 7)->nullable();
            $table->decimal('location_latitude', 10, 7)->nullable();
            $table->json('google_location_data')->nullable();
            $table->foreignIdFor(Province::class, 'province_id')->nullable();
            $table->foreignIdFor(District::class, 'district_id')->nullable();
            $table->boolean('conducted_survey_of_community_needs')->default(false);
            $table->foreignIdFor(User::class, 'created_by')->nullable();
            $table->foreignIdFor(User::class, 'updated_by')->nullable();
            $table->text('community_needs_1')->nullable();
            $table->text('community_needs_2')->nullable();
            $table->text('community_needs_3')->nullable();
            $table->text('community_needs_4')->nullable();
            $table->text('community_needs_5')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('communities');
    }
};
