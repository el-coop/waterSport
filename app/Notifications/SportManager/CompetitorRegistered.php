<?php

namespace App\Notifications\SportManager;

use App\Models\Competitor;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class CompetitorRegistered extends Notification {
    use Queueable;
    /**
     * @var Competitor
     */
    private $competitor;
    
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Competitor $competitor) {
        //
        $this->competitor = $competitor;
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
        return (new MailMessage)
            ->subject(__('admin/notifications.newUserSubject', [], 'nl'))
            ->line(__('admin/notifications.newUserHeading',[],'nl'))
            ->line(__('admin/notifications.newUserEmail',[
                'email' => $this->competitor->user->email
            ],'nl'))
            ->line(__('admin/notifications.newUserName',[
                'name' => "{$this->competitor->user->name} {$this->competitor->user->last_name}"
            ],'nl'));
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
