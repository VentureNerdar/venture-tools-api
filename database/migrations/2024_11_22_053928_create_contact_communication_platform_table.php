<?php

use App\Models\CommunicationPlatform;
use App\Models\Contact;
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
        Schema::create('contact_communication_platform', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Contact::class)->index();
            $table->foreignIdFor(CommunicationPlatform::class)->index();
            $table->string('value', 300)->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_communication_platform');
    }
};
