<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFileContentToSuratPerintahsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('surat_perintahs', function (Blueprint $table) {
            $table->longText('file_content')->nullable(); // Untuk menyimpan konten file
            $table->string('file_name')->nullable(); // Untuk menyimpan nama asli file
            $table->string('file_mime')->nullable(); // Untuk menyimpan tipe MIME
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('surat_perintahs', function (Blueprint $table) {
            $table->dropColumn(['file_content', 'file_name', 'file_mime']);
        });
    }
}