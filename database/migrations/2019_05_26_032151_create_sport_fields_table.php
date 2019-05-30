<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSportFieldsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('sport_fields', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('name_en');
			$table->string('name_nl');
			$table->string('placeholder_en');
			$table->string('placeholder_nl');
			$table->string('type');
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
	public function down() {
		Schema::dropIfExists('sport_fields');
	}
}
