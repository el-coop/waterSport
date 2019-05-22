<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\User;
use App\Models\PracticeDay;
use Illuminate\Auth\Access\HandlesAuthorization;

class PracticeDayPolicy {
	use HandlesAuthorization;

	/**
	 * Determine whether the user can view the practice day.
	 *
	 * @param  \App\Models\User $user
	 * @param  \App\Models\PracticeDay $practiceDay
	 * @return mixed
	 */
	public function view(User $user, PracticeDay $practiceDay) {
		//
	}

	/**
	 * Determine whether the user can create practice days.
	 *
	 * @param  \App\Models\User $user
	 * @return mixed
	 */
	public function create(User $user) {
		return $user->user_type == Admin::class;
	}

	/**
	 * Determine whether the user can update the practice day.
	 *
	 * @param  \App\Models\User $user
	 * @param  \App\Models\PracticeDay $practiceDay
	 * @return mixed
	 */
	public function update(User $user, PracticeDay $practiceDay) {
		return $user->user_type == Admin::class;

	}

	/**
	 * Determine whether the user can delete the practice day.
	 *
	 * @param  \App\Models\User $user
	 * @param  \App\Models\PracticeDay $practiceDay
	 * @return mixed
	 */
	public function delete(User $user, PracticeDay $practiceDay) {
		return $user->user_type == Admin::class;
	}

	/**
	 * Determine whether the user can restore the practice day.
	 *
	 * @param  \App\Models\User $user
	 * @param  \App\Models\PracticeDay $practiceDay
	 * @return mixed
	 */
	public function restore(User $user, PracticeDay $practiceDay) {
		//
	}

	/**
	 * Determine whether the user can permanently delete the practice day.
	 *
	 * @param  \App\Models\User $user
	 * @param  \App\Models\PracticeDay $practiceDay
	 * @return mixed
	 */
	public function forceDelete(User $user, PracticeDay $practiceDay) {
		//
	}
}
