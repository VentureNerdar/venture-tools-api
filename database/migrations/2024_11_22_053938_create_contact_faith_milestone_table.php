<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Contact;
use App\Models\FaithMilestone;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up() : void
    {
        Schema::create('contact_faith_milestone', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Contact::class)->index();
            $table->foreignIdFor(FaithMilestone::class)->index();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('contact_faith_milestone');
    }
};
