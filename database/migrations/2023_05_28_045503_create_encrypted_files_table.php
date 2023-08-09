<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEncryptedFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('encrypted_files', function (Blueprint $table) {
            $table->id();
            $table->string('filename');
            $table->string('user_id');
            $table->longText('encrypted_file');
            $table->string('encryption_key');
            $table->string('deskripsi');
            $table->string('file_size');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('encrypted_files');
    }
}
