<?php

namespace App\Http\Controllers;

use App\Models\CompetitionDay;
use App\Models\PracticeDay;
use ElCoop\Datatable\Controllers\DatatableController;
use ElCoop\Datatable\Services\DatatableService;
use Illuminate\Http\Request;

class SportManagerController extends DatatableController {

	public function showResetForm(Request $request, $token = null) {
		return view('competitor.setPassword')->with(
			['token' => $token]
		);
	}

	public function home(Request $request) {
		$user = $request->user();
		return view('sportManager.home', compact('user'));
	}

	public function competitionDayTable(Request $request, CompetitionDay $competitionDay) {
		$datatableService = new DatatableService($request, $competitionDay->{$request->input('attribute')});
		return $this->list($request, $datatableService);
	}

	public function practiceDayTable(Request $request, PracticeDay $practiceDay) {
		$datatableService = new DatatableService($request, $practiceDay->{$request->input('attribute')});
		return $this->list($request, $datatableService);
	}
}
