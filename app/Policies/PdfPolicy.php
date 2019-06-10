<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\User;
use App\Models\Pdf;
use Illuminate\Auth\Access\HandlesAuthorization;

class PdfPolicy {
	use HandlesAuthorization;

	/**
	 * Determine whether the user can view any pdfs.
	 *
	 * @param  \App\Models\User $user
	 * @return mixed
	 */
	public function viewAny(User $user) {
		//
	}

	/**
	 * Determine whether the user can view the pdf.
	 *
	 * @param  \App\Models\User $user
	 * @param  \App\Models\Pdf $pdf
	 * @return mixed
	 */
	public function view(User $user, Pdf $pdf) {
		//
	}

	/**
	 * Determine whether the user can create pdfs.
	 *
	 * @param  \App\Models\User $user
	 * @return mixed
	 */
	public function create(User $user) {
		return $user->user_type === Admin::class;
	}

	/**
	 * Determine whether the user can update the pdf.
	 *
	 * @param  \App\Models\User $user
	 * @param  \App\Models\Pdf $pdf
	 * @return mixed
	 */
	public function update(User $user, Pdf $pdf) {
		return $user->user_type === Admin::class;
	}

	/**
	 * Determine whether the user can delete the pdf.
	 *
	 * @param  \App\Models\User $user
	 * @param  \App\Models\Pdf $pdf
	 * @return mixed
	 */
	public function delete(User $user, Pdf $pdf) {
		return $user->user_type === Admin::class;
	}

	/**
	 * Determine whether the user can restore the pdf.
	 *
	 * @param  \App\Models\User $user
	 * @param  \App\Models\Pdf $pdf
	 * @return mixed
	 */
	public function restore(User $user, Pdf $pdf) {
		//
	}

	/**
	 * Determine whether the user can permanently delete the pdf.
	 *
	 * @param  \App\Models\User $user
	 * @param  \App\Models\Pdf $pdf
	 * @return mixed
	 */
	public function forceDelete(User $user, Pdf $pdf) {
		//
	}
}
