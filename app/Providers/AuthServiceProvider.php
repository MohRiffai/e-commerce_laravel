<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // ResetPassword::createUrlUsing(function ($user, string $token) {
        //     return 'https://projectskripsi.test/reset-password/'. $token;
        // });

        ResetPassword::createUrlUsing(function ($user, string $token) {
            return 'http://projectskripsi.test/reset-password/' . $token;
        });

        // VerifyEmail::toMailUsing(function ($notifiable, $url) {
        //     return (new MailMessage)
        //         ->subject('Verify Email Address')
        //         ->line('Click the button below to verify your email address.')
        //         ->lineIf($notifiable->provider,'Please update yout password: '. $notifiable->username)
        //         ->lineIf($notifiable->provider,'Please update yout password: '. $notifiable->password)
        //         ->action('Verify Email Address', $url);
        // });
        Gate::define('is-owner', function ($user) {
            return $user->id === 1;
        });

        Gate::define('is-pelanggan', function ($user) {
            return $user->id !== 1;
        });
    }
}
