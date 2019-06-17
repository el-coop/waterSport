<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePracticeDaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('practice_days', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamp('start_time');
			$table->timestamp('end_time');
			$table->bigInteger('sport_id')->unsigned();
            $table->timestamps();

			$table->foreign('sport_id')
				->references('id')->on('sports')
				->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('practice_days');
    }
}
