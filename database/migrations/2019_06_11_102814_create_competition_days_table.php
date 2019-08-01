<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompetitionDaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('competition_days', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->timestamp('start_time');
			$table->timestamp('end_time');
            $table->integer('max_participants')->unsigned();
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
        Schema::dropIfExists('competition_days');
    }
}
