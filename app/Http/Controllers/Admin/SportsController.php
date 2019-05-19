<?php

namespace App\Http\Controllers\Admin;

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
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(StoreSportRequest $request) {
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
	 * Update the specified resource in storage.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param \App\Models\Sport $sport
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Sport $sport) {
		//
	}
	
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param \App\Models\Sport $sport
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Sport $sport) {
		//
	}
}
