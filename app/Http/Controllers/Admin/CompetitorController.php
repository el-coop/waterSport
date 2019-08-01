<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\Competitor\DestroyCompetitorRequest;
use App\Http\Requests\Admin\Competitor\StoreCompetitorRequest;
use App\Http\Requests\Admin\Competitor\updateCompetitorRequest;
use App\Http\Requests\Competitor\UpdateCompetitorRequest as UpdateCompetitorFormRequest;
use App\Models\Competitor;
use App\Models\Sport;
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
	 * @param \App\Models\Competitor $competitor
	 * @return \Illuminate\Http\Response
	 */
	public function show(Competitor $competitor) {
		$user = $competitor->user->load('user.sports');
		$selectedSports = $competitor->sports->pluck('id');
		$sportsData = $user->user->sports->mapWithKeys(function ($sport) use ($competitor) {
			$practiceDays = $competitor->practiceDays()->select('practice_days.id')->where('sport_id', $sport->id)->get()->pluck('id');
            $competitionDays = $competitor->competitionDays()->select('competition_days.id')->where('sport_id', $sport->id)->get()->pluck('id');
            if (is_string($sport->pivot->data)) {
				$data = collect(['practiceDays' => $practiceDays]);
			} else {
				$data = collect($sport->pivot->data)->put('practiceDays', $practiceDays);
			}
            $data->put('competitionDays', $competitionDays);
            return [$sport->id => $data];
		});
		$sports = Sport::registrationOptions();
		
		return view('admin.competitors.show', compact('user', 'sports', 'selectedSports', 'sportsData'));
	}
	
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param \App\Models\Competitor $competitor
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Competitor $competitor) {
		return $competitor->fullData;
	}
	
	/**
	 * Update the specified resource in storage.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param \App\Models\Competitor $competitor
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateCompetitorRequest $request, Competitor $competitor) {
		return $request->commit();
	}
	
	public function updateForm(UpdateCompetitorFormRequest $request, Competitor $competitor) {
		$request->commit();
		return back()->with('toast', [
			'type' => 'success',
			'title' => '',
			'message' => __('vue.updateSuccess', [], $request->input('language'))
		]);
	}
	
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param DestroyCompetitorRequest $request
	 * @param \App\Models\Competitor $competitor
	 * @return void
	 */
	public function destroy(DestroyCompetitorRequest $request, Competitor $competitor) {
		$request->commit();
		return [
			'success' => true
		];
	}
}
