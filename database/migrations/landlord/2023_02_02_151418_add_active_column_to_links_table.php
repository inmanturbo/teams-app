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
        Schema::table('links', function (Blueprint $table) {
            // add the active column
            $table->boolean('active')->after('order_column')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('links', function (Blueprint $table) {
            // remove the active column
            $table->dropColumn('active');
        });
    }
};
