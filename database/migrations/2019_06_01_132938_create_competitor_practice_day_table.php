<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompetitorPracticeDayTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('competitor_practice_day', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->bigInteger('sport_id')->unsigned();
			$table->bigInteger('competitor_id')->unsigned();
			$table->bigInteger('practice_day_id')->unsigned();
			
			$table->timestamps();
			
			$table->foreign('sport_id')
				->references('id')->on('sports')
				->onDelete('cascade');
			$table->foreign('competitor_id')
				->references('id')->on('competitors')
				->onDelete('cascade');
			$table->foreign('practice_day_id')
				->references('id')->on('practice_days')
				->onDelete('cascade');
			
			$table->unique(['competitor_id', 'sport_id']);
			$table->unique(['competitor_id', 'practice_day_id']);
		});
	}
	
	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('competitor_practice_day');
	}
}
