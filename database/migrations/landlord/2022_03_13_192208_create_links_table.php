<?php

use App\Models\LinkTarget;
use App\Models\LinkType;
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
        Schema::create('links', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->foreignId('team_id')->nullable();
            $table->foreignId('user_id')->nullable();
            $table->string('type')->default(LinkType::InternalLink->value);
            $table->string('target')->default(LinkTarget::Self->value);
            $table->string('url');
            $table->string('title')->nullable();
            $table->string('label')->nullable();
            $table->string('role')->nullable();
            $table->string('view')->nullable();
            $table->string('icon')->nullable();
            $table->bigInteger('order_column')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('links');
    }
};
