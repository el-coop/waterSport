<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSportManagersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sport_managers', function (Blueprint $table) {
            $table->bigIncrements('id');
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
        Schema::dropIfExists('sport_managers');
    }
}
