<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAncentPoetryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ancent_poetry', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->tinyInteger('poetry_id');               // 古诗的id
            $table->string('poetry_content');               // 古诗诗句
            $table->tinyInteger('poetry_num');              // 诗句序号
            $table->tinyInteger('use_times');               // 使用次数
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
        Schema::dropIfExists('ancent_poetry');
    }
}
