<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\SportField\DestroySprotFieldRequest;
use App\Http\Requests\Admin\SportField\StoreSportFieldRequest;
use App\Models\Sport;
use App\Models\SportField;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class SportFieldsController extends Controller {
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
	 * @param StoreSportFieldRequest $request
	 * @param Sport $sport
	 * @return \Illuminate\Http\Response
	 */
	public function store(StoreSportFieldRequest $request, Sport $sport) {
		return $request->commit();
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\SportField $sportField
	 * @return \Illuminate\Http\Response
	 */
	public function show(SportField $sportField) {
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\SportField $sportField
	 * @return \Illuminate\Http\Response
	 */
	public function edit(SportField $sportField) {
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param StoreSportFieldRequest $request
	 * @param Sport $sport
	 * @param  \App\Models\SportField $sportField
	 * @return  Response
	 */
	public function update(StoreSportFieldRequest $request, Sport $sport, SportField $sportField) {
		return $request->commit();
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param DestroySprotFieldRequest $request
	 * @param Sport $sport
	 * @param  \App\Models\SportField $sportField
	 * @return array
	 */
	public function destroy(DestroySprotFieldRequest $request, Sport $sport, SportField $sportField) {
		$request->commit();
		return [
			'success' => true
		];
	}
}
