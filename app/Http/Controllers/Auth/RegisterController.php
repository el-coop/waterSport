<?php

namespace App\Http\Controllers\Auth;

use App;
use App\Http\Requests\Competitor\RegisterCompetitorRequest;
use App\Models\Pdf;
use App\Models\Sport;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller {
	/*
	|--------------------------------------------------------------------------
	| Register Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users as well as their
	| validation and creation. By default this controller uses a trait to
	| provide this functionality without requiring any additional code.
	|
	*/
	
	use RegistersUsers;
	
	/**
	 * Where to redirect users after registration.
	 *
	 * @var string
	 */
	protected $redirectTo = '/home';
	
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->middleware('guest');
	}
	
	/**
	 * Show the application registration form.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function showRegistrationForm() {
		$sports = Sport::select('id', 'name', 'date', 'description', 'practice_day_title_nl', 'practice_day_title_en')->with(['practiceDays' => function ($query) {
			$query->select('id', 'sport_id', 'date');
		}, 'fields' => function ($query) {
			$language = App::getLocale();
			$query->select('id', 'sport_id', 'type', "name_{$language} as title", "placeholder_{$language} as placeholder");
		}])->get()->each(function ($sport) {
			$sport->competition = $sport->date->format('d/m/Y');
			$sport->formattedDescription = nl2br($sport->description);
			$sport->practiceDays->each(function ($practiceDay) {
				$practiceDay->formattedDate = $practiceDay->date->format('d/m/Y');
			});
		});
		
		$file = Pdf::where('use', 'homepagePdf')->first();
		
		$competitor = new App\Models\Competitor;
		return view('auth.register', compact('sports', 'competitor', 'file'));
	}
	
	
	public function register(RegisterCompetitorRequest $request) {
		$request->commit();
		return redirect('login')->with('confirmEmail', true);
	}
	
	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param array $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	protected function validator(array $data) {
		return Validator::make($data, [
			'name' => ['required', 'string', 'max:255'],
			'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
			'password' => ['required', 'string', 'min:8', 'confirmed'],
		]);
	}
	
	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param array $data
	 * @return \App\Models\User
	 */
	protected function create(array $data) {
		return User::create([
			'name' => $data['name'],
			'email' => $data['email'],
			'password' => Hash::make($data['password']),
		]);
	}
}
