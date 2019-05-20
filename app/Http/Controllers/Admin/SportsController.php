<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\Sports\DestroySportRequest;
use App\Http\Requests\Admin\Sports\StoreSportRequest;
use App\Models\Sport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SportsController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		return view('admin.sports.index');
	}
	
	
	/**
	 * Store a newly created resource in storage.
	 *
	 * @param StoreSportRequest $request
	 * @param Sport $sport
	 * @return \Illuminate\Http\Response
	 */
	public function store(StoreSportRequest $request, Sport $sport) {
		return $request->commit();
	}
	
	
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param \App\Models\Sport $sport
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Sport $sport) {
		return $sport->fullData;
	}
	
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param DestroySportRequest $request
	 * @param \App\Models\Sport $sport
	 * @return void
	 */
	public function destroy(DestroySportRequest $request, Sport $sport) {
		$request->commit();
		return [
			'success' => true
		];
	}
}
