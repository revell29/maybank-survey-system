<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLevelSurveiResult extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('survei_results', function (Blueprint $table) {
            $table->integer('level_1')->nullable();
            $table->integer('level_2')->nullable();
            $table->integer('level_3')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('survei_results', function (Blueprint $table) {
            //
        });
    }
}
