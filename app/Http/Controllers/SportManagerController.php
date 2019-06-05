<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SportManagerController extends Controller {

	public function showResetForm(Request $request, $token = null) {
		return view('competitor.setPassword')->with(
			['token' => $token]
		);
	}
}
