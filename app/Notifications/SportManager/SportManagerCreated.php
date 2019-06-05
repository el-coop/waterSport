<?php

namespace App\Notifications\SportManager;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class SportManagerCreated extends Notification {
	use Queueable;
	private $token;

	/**
	 * Create a new notification instance.
	 *
	 * @return void
	 */
	public function __construct($token) {
		$this->token = $token;

	}

	/**
	 * Get the notification's delivery channels.
	 *
	 * @param mixed $notifiable
	 * @return array
	 */
	public function via($notifiable) {
		return ['mail'];
	}

	/**
	 * Get the mail representation of the notification.
	 *
	 * @param mixed $notifiable
	 * @return \Illuminate\Notifications\Messages\MailMessage
	 */
	public function toMail($notifiable) {
		$message = explode(PHP_EOL, app('settings')->get("sport_manager_registration_email_body_{$notifiable->language}"));
		$email = (new MailMessage)
			->subject(app('settings')->get("sport_manager_registration_email_subject_{$notifiable->language}"))
			->greeting(__('notification.greeting', ['name' => $notifiable->name]));


		foreach ($message as $line) {
			$email->line($line);
		}

		$email->action(__('competitors.fillProfile', [], $notifiable->language), action('SportManagerController@showResetForm', $this->token, true));

		return $email;
	}

	/**
	 * Get the array representation of the notification.
	 *
	 * @param mixed $notifiable
	 * @return array
	 */
	public function toArray($notifiable) {
		return [
			//
		];
	}
}
