<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDztmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 德智体美表
        if(!Schema::hasTable('dztm')){
            Schema::create('dztm', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->float('sports_grade');
                $table->float('intelligence_grade');
                $table->float('xuehao_grade');
                $table->float('beautiful_grade');
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
        Schema::dropIfExists('dztm');
    }
}
