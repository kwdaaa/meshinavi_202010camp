<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdataUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unique(['name']);
            $table->dropUnique(['email']);
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */

    // ロールバックするときの処理
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['name']);
            $table->unique(['email']);
        });
    }
}
