<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddComlumnMahasiswa extends Migration
{
    public function up()
    {
        Schema::table('mahasiswa', function (Blueprint $table) {
            $table->string('email', 25)->after('id_mahasiswa')->nullable();
            $table->string('alamat', 50);
            $table->string('tanggal_lahir', 5);
        });
    }
    public function down()
    {
        Schema::table('mahasiswa', function (Blueprint $table) {
            $table->dropColumn('email');
            $table->dropColumn('alamat');
            $table->dropColumn('tanggal_lahir');
        });
    }
}
