<?php

namespace App\Models;

use App\Notifications\Competitor\CompetitorCreated;
use App\Notifications\SportManager\SportManagerCreated;
use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable {
	use Notifiable;
	
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name', 'email', 'password'
	];
	
	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];
	
	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'email_verified_at' => 'datetime',
	];
	
	public function user() {
		return $this->morphTo();
	}
	
	public function sendPasswordResetNotification($token) {
		if ($this->password !== '' || !in_array($this->user_type, [Competitor::class, SportManager::class])) {
			$this->notify(new ResetPasswordNotification($token));
			return;
		}
		if ( $this->user_type == SportManager::class){
			$this->notify(new SportManagerCreated($token));
		} else {
			$this->notify(new CompetitorCreated($token));
		}
	}
}
