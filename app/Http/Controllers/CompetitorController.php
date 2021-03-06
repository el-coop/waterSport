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
		$locale = App::getLocale();
		$message = app('settings')->get("confirmation_success_text_{$locale}");
		
		$user = $request->user()->load('user.sports');
		$selectedSports = $user->user->sports->pluck('id');
		$sportsData = $user->user->sports->mapWithKeys(function ($sport) use ($user) {
			$practiceDays = $user->user->practiceDays()->select('practice_days.id')->where('sport_id', $sport->id)->get()->pluck('id');
			$competitionDays = $user->user->competitionDays()->select('competition_days.id')->where('sport_id', $sport->id)->get()->pluck('id');
			if (is_string($sport->pivot->data)) {
				$data = collect(['practiceDays' => $practiceDays]);
			} else {
				$data = collect($sport->pivot->data)->put('practiceDays', $practiceDays);
			}
			$data->put('competitionDays', $competitionDays);
			return [$sport->id => $data];
		});
		$sports = Sport::registrationOptions();
        
        return view('competitor.view', compact('user', 'sports', 'selectedSports', 'sportsData', 'message'));
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
	
	public function showResetForm(Request $request, $token = null) {
		return view('competitor.setPassword')->with(
			['token' => $token]
		);
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
