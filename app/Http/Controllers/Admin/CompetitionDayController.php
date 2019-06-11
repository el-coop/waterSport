<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\CompetitionDay\DestroyCompetitionDayRequest;
use App\Http\Requests\Admin\CompetitionDay\StoreCompetitionDayRequest;
use App\Models\CompetitionDay;
use App\Models\Sport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CompetitionDayController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param StoreCompetitionDayRequest $request
	 * @param Sport $sport
	 * @param CompetitionDay $competitionDay
	 * @return \Illuminate\Http\Response
	 */
	public function store(StoreCompetitionDayRequest $request, Sport $sport, CompetitionDay $competitionDay) {
		return $request->commit();
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\CompetitionDay $competitionDay
	 * @return \Illuminate\Http\Response
	 */
	public function show(CompetitionDay $competitionDay) {
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\CompetitionDay $competitionDay
	 * @return \Illuminate\Http\Response
	 */
	public function edit(CompetitionDay $competitionDay) {
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param StoreCompetitionDayRequest $request
	 * @param Sport $sport
	 * @param  \App\Models\CompetitionDay $competitionDay
	 * @return \Illuminate\Http\Response
	 */
	public function update(StoreCompetitionDayRequest $request, Sport $sport, CompetitionDay $competitionDay) {
		return $request->commit();
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param DestroyCompetitionDayRequest $request
	 * @param Sport $sport
	 * @param  \App\Models\CompetitionDay $competitionDay
	 * @return array
	 */
	public function destroy(DestroyCompetitionDayRequest $request,Sport $sport, CompetitionDay $competitionDay) {
		$request->commit();
		return [
			'success' => true
		];
	}
}
