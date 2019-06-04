<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\SportManager\DestroySportManagerRequest;
use App\Http\Requests\Admin\SportManager\StoreSportManagerRequest;
use App\Http\Requests\Admin\SportManager\UpdateSportManagerRequest;
use App\Models\SportManager;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SportManagerController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		return view('admin.sports.sportManagers');
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
	 * @param  \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(StoreSportManagerRequest $request, SportManager $sportManager) {
		return $request->commit();
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\SportManager $sportManager
	 * @return \Illuminate\Http\Response
	 */
	public function show(SportManager $sportManager) {
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\SportManager $sportManager
	 * @return \Illuminate\Http\Response
	 */
	public function edit(SportManager $sportManager) {
		return $sportManager->fullData;
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \App\Models\SportManager $sportManager
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateSportManagerRequest $request, SportManager $sportManager) {
		return $request->commit();
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param DestroySportManagerRequest $request
	 * @param  \App\Models\SportManager $sportManager
	 * @return array
	 */
	public function destroy(DestroySportManagerRequest $request,SportManager $sportManager) {
		$request->commit();
		return [
			'success' => true
		];
	}
}
