<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('surat_perintahs', function (Blueprint $table) {
            $table->enum('status', ['belum_mulai', 'proses', 'selesai'])->default('belum_mulai');
        });
    }

    public function down()
    {
        Schema::table('surat_perintahs', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
