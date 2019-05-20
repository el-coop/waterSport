<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\User;
use App\Models\Sport;
use Illuminate\Auth\Access\HandlesAuthorization;

class SportPolicy {
	use HandlesAuthorization;
	
	/**
	 * Determine whether the user can view the sport.
	 *
	 * @param \App\Models\User $user
	 * @param \App\Models\Sport $sport
	 * @return mixed
	 */
	public function view(User $user, Sport $sport) {
		//
	}
	
	/**
	 * Determine whether the user can create sports.
	 *
	 * @param \App\Models\User $user
	 * @return mixed
	 */
	public function create(User $user) {
		return $user->user_type === Admin::class;
	}
	
	/**
	 * Determine whether the user can update the sport.
	 *
	 * @param \App\Models\User $user
	 * @param \App\Models\Sport $sport
	 * @return mixed
	 */
	public function update(User $user, Sport $sport) {
		return $user->user_type === Admin::class;
	}
	
	/**
	 * Determine whether the user can delete the sport.
	 *
	 * @param \App\Models\User $user
	 * @param \App\Models\Sport $sport
	 * @return mixed
	 */
	public function delete(User $user, Sport $sport) {
		return $user->user_type === Admin::class;
	}
	
	/**
	 * Determine whether the user can restore the sport.
	 *
	 * @param \App\Models\User $user
	 * @param \App\Models\Sport $sport
	 * @return mixed
	 */
	public function restore(User $user, Sport $sport) {
		//
	}
	
	/**
	 * Determine whether the user can permanently delete the sport.
	 *
	 * @param \App\Models\User $user
	 * @param \App\Models\Sport $sport
	 * @return mixed
	 */
	public function forceDelete(User $user, Sport $sport) {
		//
	}
}
