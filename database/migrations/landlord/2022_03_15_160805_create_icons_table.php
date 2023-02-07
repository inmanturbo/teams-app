<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    /**
     * The database schema.
     *
     * @var \Illuminate\Database\Schema\Builder
     */
    protected $schema;
    
    /**
     * Create a new migration instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->schema = Schema::connection($this->getConnection());
    }

    /**
     * Get the migration connection name.
     */
    public function getConnection(): ?string
    {
        return config('buku-icons.db_connection');
    }

    public function up(): void
    {
        $this->schema->create('icons', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('icon_set_id');
            $table->string('name');
            $table->json('keywords');
            $table->boolean('outlined');
            $table->timestamps();
        });
    }
    
    public function down(): void
    {
        $this->schema->dropIfExists('icons');
    }
};;
