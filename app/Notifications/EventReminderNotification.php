<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Event;

class EventReminderNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public Event $event
    )
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Event Reminder: ' . $this->event->name)
            ->line('Reminder: You have an upcoming event!')
            ->line("Event: {$this->event->name}")
            ->line("Description: {$this->event->description}")
            ->line("Start Time: {$this->event->start_time}")
            ->line("End Time: {$this->event->end_time}")
            ->action('View Event', url('/api/events/' . $this->event->id))
            ->line('Thank you for using Event Management!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'event_id' => $this->event->id,
            'event_name' => $this->event->name,
            'event_start_time' => $this->event->start_time,
        ];
    }
}
