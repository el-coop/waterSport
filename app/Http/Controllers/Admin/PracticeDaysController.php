<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\PracticeDay\DestroyPracticeDayRequest;
use App\Http\Requests\Admin\PracticeDay\StorePracticeDayRequest;
use App\Models\PracticeDay;
use App\Models\Sport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PracticeDaysController extends Controller {
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
	 * @param StorePracticeDayRequest $request
	 * @param Sport $sport
	 * @param PracticeDay $practiceDay
	 * @return \Illuminate\Http\Response
	 */
	public function store(StorePracticeDayRequest $request, Sport $sport, PracticeDay $practiceDay) {
		return $request->commit();
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\PracticeDay $practiceDay
	 * @return \Illuminate\Http\Response
	 */
	public function show(PracticeDay $practiceDay) {
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\PracticeDay $practiceDay
	 * @return \Illuminate\Http\Response
	 */
	public function edit(PracticeDay $practiceDay) {
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param StorePracticeDayRequest $request
	 * @param Sport $sport
	 * @param  \App\Models\PracticeDay $practiceDay
	 * @return \Illuminate\Http\Response
	 */
	public function update(StorePracticeDayRequest $request, Sport $sport, PracticeDay $practiceDay) {
		return $request->commit();
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param DestroyPracticeDayRequest $request
	 * @param Sport $sport
	 * @param  \App\Models\PracticeDay $practiceDay
	 * @return array
	 */
	public function destroy(DestroyPracticeDayRequest $request, Sport $sport, PracticeDay $practiceDay) {
		$request->commit();
		return [
			'success' => true
		];
	}
}
