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
        Schema::table('kegiatans', function (Blueprint $table) {
            $table->enum('status', ['Review', 'Ditolak', 'Diterima'])->default('Review');
        });
    }

    public function down()
    {
        Schema::table('kegiatans', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
