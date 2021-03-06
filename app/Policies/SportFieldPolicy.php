<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\User;
use App\Models\SportField;
use Illuminate\Auth\Access\HandlesAuthorization;

class SportFieldPolicy {
	use HandlesAuthorization;

	/**
	 * Determine whether the user can view the sport field.
	 *
	 * @param  \App\Models\User $user
	 * @param  \App\Models\SportField $sportField
	 * @return mixed
	 */
	public function view(User $user, SportField $sportField) {
		//
	}

	/**
	 * Determine whether the user can create sport fields.
	 *
	 * @param  \App\Models\User $user
	 * @return mixed
	 */
	public function create(User $user) {
		return $user->user_type === Admin::class;
	}

	/**
	 * Determine whether the user can update the sport field.
	 *
	 * @param  \App\Models\User $user
	 * @param  \App\Models\SportField $sportField
	 * @return mixed
	 */
	public function update(User $user, SportField $sportField) {
		return $user->user_type === Admin::class;
	}

	/**
	 * Determine whether the user can delete the sport field.
	 *
	 * @param  \App\Models\User $user
	 * @param  \App\Models\SportField $sportField
	 * @return mixed
	 */
	public function delete(User $user, SportField $sportField) {
		return $user->user_type === Admin::class;
	}

	/**
	 * Determine whether the user can restore the sport field.
	 *
	 * @param  \App\Models\User $user
	 * @param  \App\Models\SportField $sportField
	 * @return mixed
	 */
	public function restore(User $user, SportField $sportField) {
		//
	}

	/**
	 * Determine whether the user can permanently delete the sport field.
	 *
	 * @param  \App\Models\User $user
	 * @param  \App\Models\SportField $sportField
	 * @return mixed
	 */
	public function forceDelete(User $user, SportField $sportField) {
		//
	}
}
