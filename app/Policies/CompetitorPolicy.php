<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\User;
use App\Models\Competitor;
use Illuminate\Auth\Access\HandlesAuthorization;

class CompetitorPolicy {
	use HandlesAuthorization;

	/**
	 * Determine whether the user can view the competitor.
	 *
	 * @param  \App\Models\User $user
	 * @param  \App\Models\Competitor $competitor
	 * @return mixed
	 */
	public function view(User $user, Competitor $competitor) {
		//
	}

	/**
	 * Determine whether the user can create competitors.
	 *
	 * @param  \App\Models\User $user
	 * @return mixed
	 */
	public function create(User $user) {
		return $user->user_type === Admin::class;
	}

	/**
	 * Determine whether the user can update the competitor.
	 *
	 * @param  \App\Models\User $user
	 * @param  \App\Models\Competitor $competitor
	 * @return mixed
	 */
	public function update(User $user, Competitor $competitor) {
		return $user->user_type === Admin::class;
	}

	/**
	 * Determine whether the user can delete the competitor.
	 *
	 * @param  \App\Models\User $user
	 * @param  \App\Models\Competitor $competitor
	 * @return mixed
	 */
	public function delete(User $user, Competitor $competitor) {
		return $user->user_type === Admin::class;
	}

	/**
	 * Determine whether the user can restore the competitor.
	 *
	 * @param  \App\Models\User $user
	 * @param  \App\Models\Competitor $competitor
	 * @return mixed
	 */
	public function restore(User $user, Competitor $competitor) {
		//
	}

	/**
	 * Determine whether the user can permanently delete the competitor.
	 *
	 * @param  \App\Models\User $user
	 * @param  \App\Models\Competitor $competitor
	 * @return mixed
	 */
	public function forceDelete(User $user, Competitor $competitor) {
		//
	}
}
