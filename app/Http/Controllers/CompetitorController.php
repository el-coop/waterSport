<?php

namespace App\Http\Controllers;

use App;
use App\Http\Requests\Competitor\UpdateCompetitorRequest;
use App\Models\Competitor;
use App\Models\Sport;
use Illuminate\Http\Request;

class CompetitorController extends Controller {
	
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Request $request) {
		$user = $request->user()->load('user.sports');
		$selectedSports = $user->user->sports->pluck('id');
		$sportsData = $user->user->sports->mapWithKeys(function ($sport) {
			$data = collect($sport->pivot->data)->put('practiceDay', $sport->pivot->practice_day_id);
			return [$sport->id => $data];
		});
		$sports = Sport::select('id', 'name', 'date')->with(['practiceDays' => function ($query) {
			$query->select('id', 'sport_id', 'date');
		}, 'fields' => function ($query) {
			$language = App::getLocale();
			$query->select('id', 'sport_id', 'type', "name_{$language} as title", "placeholder_{$language} as placeholder");
		}])->get()->each(function ($sport) {
			$sport->competition = $sport->date->format('d/m/Y');
			$sport->practiceDays->each(function ($practiceDay) {
				$practiceDay->formattedDate = $practiceDay->date->format('d/m/Y');
			});
		});
		return view('competitor.view', compact('user', 'sports', 'selectedSports', 'sportsData'));
	}
	
	/**
	 * Update the specified resource in storage.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param \App\Models\Competitor $competitor
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateCompetitorRequest $request, Competitor $competitor) {
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
	 * @param \App\Models\Competitor $competitor
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Competitor $competitor) {
		//
	}
}
