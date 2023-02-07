<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->uuid();
            $table->id();
            $table->foreignId('user_id')->index();
            $table->string('name');
            $table->string('domain')->nullable();
            $table->boolean('personal_team');
            $table->string('profile_photo_path', 2048)->nullable();
            $table->text('team_data')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('teams');
    }
};
