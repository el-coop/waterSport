<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSportsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('sports', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('name')->unique();
			$table->text('description');
			$table->string('practice_day_title_nl')->default('Practice Day');
			$table->string('practice_day_title_en')->default('Practice Day');
			$table->timestamp('date');
			$table->timestamps();
		});
	}
	
	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('sports');
	}
}
