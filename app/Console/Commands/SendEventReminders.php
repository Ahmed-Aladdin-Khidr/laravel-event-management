<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use App\Notifications\EventReminderNotification;
class SendEventReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-event-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends notifications to all event attendees that event starts soon';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $events = \App\Models\Event::with('attendees.user')
            ->whereBetween('start_time', [now(), now()->addDays(1)])
            ->get();

        $eventCount = $events->count();
        $eventLable = Str::plural('event', $eventCount);

        $this->info('Found ' . $eventCount . ' ' . $eventLable . ' to remind');

        $events->each(function ($event) {
            $event->attendees->each(function ($attendee) {
                $attendee->user->notify(new EventReminderNotification($attendee->event));
                $this->info('Sent reminder to ' . $attendee->user->name);
            });
        });

        $this->info('Sent ' . $eventCount . ' ' . $eventLable . ' reminders');
    }
}
