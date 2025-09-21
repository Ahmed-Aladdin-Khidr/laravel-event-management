<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;
use Illuminate\Cache\RateLimiting\Limit;
use App\Models\User;
use App\Models\Event;
use App\Models\Attendee;
use App\Policies\EventPolicy;
use App\Policies\AttendeePolicy;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register policies for automatic resolution
        Gate::policy(Event::class, EventPolicy::class);
        Gate::policy(Attendee::class, AttendeePolicy::class);

        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
        
        // Keep custom gates if needed
        // Gate::define('update-event', function (User $user, Event $event) {
        //     return $user->id === $event->user_id;
        // });
        // Gate::define('delete-attendee', function (User $user, Event $event, Attendee $attendee) {
        //     return $user->id === $event->user_id || $user->id === $attendee->user_id;
        // });
    }
}
