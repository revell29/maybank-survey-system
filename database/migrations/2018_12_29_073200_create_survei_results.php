<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSurveiResults extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survei_results', function (Blueprint $table) {
            $table->increments('id');
            $table->string('survei_emot')->nullable();
            $table->unsignedInteger('branch_id')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->index(['branch_id','user_id']);

            $table->foreign('branch_id')
                ->references('id')
                ->on('branches')
                ->onDelete('set null');

            $table->foreign('user_id')
                ->references('id')
                ->on('user_branchs')
                ->onDelete('cascade');
            
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
        Schema::dropIfExists('survei_results');
    }
}
