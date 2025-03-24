<?php

use App\Models\Contact;
use App\Models\PeopleGroup;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up() : void
    {
        Schema::create('contact_people_group', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Contact::class, 'contact_id');
            $table->foreignIdFor(PeopleGroup::class, 'people_group_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('contact_people_group');
    }
};
