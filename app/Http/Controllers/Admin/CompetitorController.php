<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\Competitor\DestroyCompetitorRequest;
use App\Http\Requests\Admin\Competitor\StoreCompetitorRequest;
use App\Http\Requests\Admin\Competitor\updateCompetitorRequest;
use App\Models\Competitor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CompetitorController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		return view('admin.competitors.index');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param StoreCompetitorRequest $request
	 * @param Competitor $competitor
	 * @return \Illuminate\Http\Response
	 */
	public function store(StoreCompetitorRequest $request, Competitor $competitor) {
		return $request->commit();
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\Competitor $competitor
	 * @return \Illuminate\Http\Response
	 */
	public function show(Competitor $competitor) {
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Competitor $competitor
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Competitor $competitor) {
		return $competitor->fullData;
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \App\Models\Competitor $competitor
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateCompetitorRequest $request, Competitor $competitor) {
		return $request->commit();
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param DestroyCompetitorRequest $request
	 * @param  \App\Models\Competitor $competitor
	 * @return void
	 */
	public function destroy(DestroyCompetitorRequest $request, Competitor $competitor) {
		$request->commit();
		return [
			'success' => true
		];
	}
}
