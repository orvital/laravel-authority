<?php

namespace Orvital\Auth\Invites\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\URL;

class InviteUser extends Notification
{
    /**
     * The invite token.
     */
    public string $token;

    /**
     * The callback that should be used to create the invite URL.
     *
     * @var (\Closure(mixed, string): string)|null
     */
    public static $createUrlCallback;

    /**
     * The callback that should be used to build the mail message.
     *
     * @var (\Closure(mixed, string): \Illuminate\Notifications\Messages\MailMessage)|null
     */
    public static $toMailCallback;

    /**
     * Create a notification instance.
     */
    public function __construct(string $token): void
    {
        $this->token = $token;
    }

    /**
     * Get the notification's channels.
     */
    public function via(mixed $notifiable): array|string
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     */
    public function toMail(mixed $notifiable): MailMessage
    {
        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable, $this->token);
        }

        return $this->buildMailMessage($this->acceptUrl($notifiable));
    }

    /**
     * Get the accept invite notification mail message for the given URL.
     */
    protected function buildMailMessage(string $url): MailMessage
    {
        return (new MailMessage())
            ->subject(Lang::get('Invite Received Notification'))
            ->line(Lang::get('You are receiving this email because you have received an invite request.'))
            ->action(Lang::get('Accept Invite'), $url)
            ->line(Lang::get('This link will expire in :count minutes.', [
                'count' => config('auth.invites.'.config('auth.defaults.invites').'.expire'),
            ]))
            ->line(Lang::get('If you did not request an invite, no further action is required.'));
    }

    /**
     * Get the accept URL for the given notifiable.
     */
    protected function acceptUrl(mixed $notifiable): string
    {
        if (static::$createUrlCallback) {
            return call_user_func(static::$createUrlCallback, $notifiable, $this->token);
        }

        return URL::route('invite.accept', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForInvite(),
        ]);
    }

    /**
     * Set a callback that should be used when creating the invite button URL.
     *
     * @param  \Closure(mixed, string): string  $callback
     */
    public static function createUrlUsing($callback): void
    {
        static::$createUrlCallback = $callback;
    }

    /**
     * Set a callback that should be used when building the notification mail message.
     *
     * @param  \Closure(mixed, string): \Illuminate\Notifications\Messages\MailMessage  $callback
     */
    public static function toMailUsing($callback): void
    {
        static::$toMailCallback = $callback;
    }
}
