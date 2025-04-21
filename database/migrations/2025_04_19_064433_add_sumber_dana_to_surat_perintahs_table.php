<?php

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
        Schema::table('surat_perintahs', function (Blueprint $table) {
            $table->enum('sumber_dana', ['anggaran', 'non_anggaran'])->default('non_anggaran');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('surat_perintahs', function (Blueprint $table) {
            $table->dropColumn('sumber_dana');
        });
    }
};
