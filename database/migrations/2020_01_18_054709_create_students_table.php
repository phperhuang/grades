<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('students')){
            Schema::create('students', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('class', 5);
                $table->float('chinese');
                $table->float('math');
                $table->float('english');
                $table->float('political');
                $table->float('history');
                $table->float('biology');
                $table->string('describe', 20);
                $table->integer('total_points');                        // 总分
                $table->integer('class_ranking');                       // 班级排名
                $table->integer('grade_ranking');                       // 年级排名
                $table->timestamps();
            });
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
}
