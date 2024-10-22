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
        Schema::table('m_user', function (Blueprint $table) {
            $table->string('avatar')->nullable(); // Kolom avatar
        });
    }

    public function down()
    {
        Schema::table('m_user', function (Blueprint $table) {
            $table->dropColumn('avatar'); // Hapus kolom avatar saat rollback
        });
    }

};
