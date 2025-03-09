<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Doctrine\DBAL\Types\Type;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // For MySQL, we need to use a DB statement for LONGBLOB
        DB::statement('ALTER TABLE kegiatans MODIFY image LONGBLOB');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // To revert back to LONGTEXT
        DB::statement('ALTER TABLE kegiatans MODIFY image LONGTEXT');
    }
};