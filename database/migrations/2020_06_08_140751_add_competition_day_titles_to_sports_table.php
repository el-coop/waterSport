<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCompetitionDayTitlesToSportsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('sports', function (Blueprint $table) {
            $table->string('competition_day_title_en')->default(__('vue.competitionDates', [], 'en'))->after('description');
            $table->string('competition_day_title_nl')->default(__('vue.competitionDates', [], 'nl'))->after('description');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('sports', function (Blueprint $table) {
            //
        });
    }
}
