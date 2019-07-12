<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\User;
use App\Models\CompetitorExportColumn;
use Illuminate\Auth\Access\HandlesAuthorization;

class CompetitorExportColumnPolicy {
	use HandlesAuthorization;

	/**
	 * Determine whether the user can view any competitor export columns.
	 *
	 * @param  \App\Models\User $user
	 * @return mixed
	 */
	public function viewAny(User $user) {
		//
	}

	/**
	 * Determine whether the user can view the competitor export column.
	 *
	 * @param  \App\Models\User $user
	 * @param  \App\Models\CompetitorExportColumn $competitorExportColumn
	 * @return mixed
	 */
	public function view(User $user, CompetitorExportColumn $competitorExportColumn) {
	}

	/**
	 * Determine whether the user can create competitor export columns.
	 *
	 * @param  \App\Models\User $user
	 * @return mixed
	 */
	public function create(User $user) {
		return $user->user_type === Admin::class;
	}

	/**
	 * Determine whether the user can update the competitor export column.
	 *
	 * @param  \App\Models\User $user
	 * @param  \App\Models\CompetitorExportColumn $competitorExportColumn
	 * @return mixed
	 */
	public function update(User $user, CompetitorExportColumn $competitorExportColumn) {
		return $user->user_type === Admin::class;

	}

	/**
	 * Determine whether the user can delete the competitor export column.
	 *
	 * @param  \App\Models\User $user
	 * @param  \App\Models\CompetitorExportColumn $competitorExportColumn
	 * @return mixed
	 */
	public function delete(User $user, CompetitorExportColumn $competitorExportColumn) {
		return $user->user_type === Admin::class;

	}

	/**
	 * Determine whether the user can restore the competitor export column.
	 *
	 * @param  \App\Models\User $user
	 * @param  \App\Models\CompetitorExportColumn $competitorExportColumn
	 * @return mixed
	 */
	public function restore(User $user, CompetitorExportColumn $competitorExportColumn) {
		//
	}

	/**
	 * Determine whether the user can permanently delete the competitor export column.
	 *
	 * @param  \App\Models\User $user
	 * @param  \App\Models\CompetitorExportColumn $competitorExportColumn
	 * @return mixed
	 */
	public function forceDelete(User $user, CompetitorExportColumn $competitorExportColumn) {
		//
	}

	public function order(User $user) {
		return $user->user_type === Admin::class;
	}
}
