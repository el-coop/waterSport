<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\User;
use App\Models\CompetitionDay;
use Illuminate\Auth\Access\HandlesAuthorization;

class CompetitionDayPolicy {
	use HandlesAuthorization;

	/**
	 * Determine whether the user can view any competition days.
	 *
	 * @param  \App\Models\User $user
	 * @return mixed
	 */
	public function viewAny(User $user) {
		//
	}

	/**
	 * Determine whether the user can view the competition day.
	 *
	 * @param  \App\Models\User $user
	 * @param  \App\Models\CompetitionDay $competitionDay
	 * @return mixed
	 */
	public function view(User $user, CompetitionDay $competitionDay) {
		//
	}

	/**
	 * Determine whether the user can create competition days.
	 *
	 * @param  \App\Models\User $user
	 * @return mixed
	 */
	public function create(User $user) {
		return $user->user_type === Admin::class;
	}

	/**
	 * Determine whether the user can update the competition day.
	 *
	 * @param  \App\Models\User $user
	 * @param  \App\Models\CompetitionDay $competitionDay
	 * @return mixed
	 */
	public function update(User $user, CompetitionDay $competitionDay) {
		return $user->user_type === Admin::class;
	}

	/**
	 * Determine whether the user can delete the competition day.
	 *
	 * @param  \App\Models\User $user
	 * @param  \App\Models\CompetitionDay $competitionDay
	 * @return mixed
	 */
	public function delete(User $user, CompetitionDay $competitionDay) {
		return $user->user_type === Admin::class;
	}

	/**
	 * Determine whether the user can restore the competition day.
	 *
	 * @param  \App\Models\User $user
	 * @param  \App\Models\CompetitionDay $competitionDay
	 * @return mixed
	 */
	public function restore(User $user, CompetitionDay $competitionDay) {
		//
	}

	/**
	 * Determine whether the user can permanently delete the competition day.
	 *
	 * @param  \App\Models\User $user
	 * @param  \App\Models\CompetitionDay $competitionDay
	 * @return mixed
	 */
	public function forceDelete(User $user, CompetitionDay $competitionDay) {
		//
	}
}
