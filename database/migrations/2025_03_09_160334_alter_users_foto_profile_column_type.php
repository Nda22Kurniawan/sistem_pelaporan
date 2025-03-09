<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Hapus kolom foto_profile yang lama
            $table->dropColumn('foto_profile');
        });

        Schema::table('users', function (Blueprint $table) {
            // Buat kolom foto_profile baru dengan tipe LONGBLOB
            $table->binary('foto_profile')->nullable();
        });

        // Ubah kolom menjadi LONGBLOB karena Laravel tidak support LONGBLOB secara langsung
        DB::statement('ALTER TABLE users MODIFY foto_profile LONGBLOB');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Hapus kolom foto_profile
            $table->dropColumn('foto_profile');
        });

        Schema::table('users', function (Blueprint $table) {
            // Buat ulang kolom dengan tipe string
            $table->string('foto_profile')->nullable();
        });
    }
};