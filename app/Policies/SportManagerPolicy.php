<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\User;
use App\Models\SportManager;
use Illuminate\Auth\Access\HandlesAuthorization;

class SportManagerPolicy {
	use HandlesAuthorization;

	/**
	 * Determine whether the user can view the sport manager.
	 *
	 * @param  \App\Models\User $user
	 * @param  \App\Models\SportManager $sportManager
	 * @return mixed
	 */
	public function view(User $user, SportManager $sportManager) {
		//
	}

	/**
	 * Determine whether the user can create sport managers.
	 *
	 * @param  \App\Models\User $user
	 * @return mixed
	 */
	public function create(User $user) {
		return $user->user_type === Admin::class;
	}

	/**
	 * Determine whether the user can update the sport manager.
	 *
	 * @param  \App\Models\User $user
	 * @param  \App\Models\SportManager $sportManager
	 * @return mixed
	 */
	public function update(User $user, SportManager $sportManager) {
		return $user->user_type === Admin::class;

	}

	/**
	 * Determine whether the user can delete the sport manager.
	 *
	 * @param  \App\Models\User $user
	 * @param  \App\Models\SportManager $sportManager
	 * @return mixed
	 */
	public function delete(User $user, SportManager $sportManager) {
		return $user->user_type === Admin::class;

	}

	/**
	 * Determine whether the user can restore the sport manager.
	 *
	 * @param  \App\Models\User $user
	 * @param  \App\Models\SportManager $sportManager
	 * @return mixed
	 */
	public function restore(User $user, SportManager $sportManager) {
		//
	}

	/**
	 * Determine whether the user can permanently delete the sport manager.
	 *
	 * @param  \App\Models\User $user
	 * @param  \App\Models\SportManager $sportManager
	 * @return mixed
	 */
	public function forceDelete(User $user, SportManager $sportManager) {
		//
	}
}
