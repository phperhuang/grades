<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePoetryInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('poetry_info', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('poetry_name', 51);          // 古诗名
            $table->string('author', 24);               // 作者
            $table->tinyInteger('level');                     // 所属年级
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
        Schema::dropIfExists('poetry_info');
    }
}
