<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompetitionDayCompetitorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('competition_day_competitor', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->bigInteger('competitor_id')->unsigned();
			$table->bigInteger('competition_day_id')->unsigned();
			$table->timestamps();
	
			$table->foreign('competitor_id')
				->references('id')->on('competitors')
				->onDelete('cascade');
	
			$table->foreign('competition_day_id')
				->references('id')->on('competition_days')
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
        Schema::dropIfExists('competition_day_competitor');
    }
}
