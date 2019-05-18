<?php
/**
 * Created by PhpStorm.
 * User: adamb
 * Date: 17/05/2019
 * Time: 11:17
 */

namespace ElCoop\Navbar\Services;

class NavbarService {


	public static function getItems($userType) {
		if ($userType == '') {
			return config('default.navbar', []);
		}
		$userType = class_basename($userType);
		return config($userType . '.navbar', config('default.navbar', []));
	}
}