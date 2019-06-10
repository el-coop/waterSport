<?php

namespace App\Notifications\Competitor;

use App\Models\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Storage;

class CompetitorCreated extends Notification implements ShouldQueue {
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
		$file = Pdf::first();
		$message = explode(PHP_EOL, app('settings')->get("registration_email_body_{$notifiable->language}"));
		$email = (new MailMessage)
			->subject(app('settings')->get("registration_email_subject_{$notifiable->language}"))
			->greeting(__('notification.greeting', ['name' => $notifiable->name]));


		foreach ($message as $line) {
			$email->line($line);
		}
		if ($file){
			$email->attach(storage_path("app/public /pdf/{$file->file}"), [
				'as' => $file->name . '.pdf',
				'mime' => 'application/pdf'
			]);
		}

		$email->action(__('competitors.fillProfile', [], $notifiable->language), action('CompetitorController@showResetForm', $this->token, true));

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
