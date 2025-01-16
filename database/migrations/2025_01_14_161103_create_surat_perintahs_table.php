<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuratPerintahsTable extends Migration
{
    public function up()
    {
        Schema::create('surat_perintahs', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat');
            $table->date('tanggal_surat');
            $table->string('perihal');
            $table->text('dasar_surat')->nullable();
            $table->string('file')->nullable();
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('surat_perintahs');
    }
}
