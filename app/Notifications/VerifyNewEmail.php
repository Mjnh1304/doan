<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Config;

class VerifyNewEmail extends Notification
{
    use Queueable;

    protected $newEmail;

    public function __construct($newEmail)
    {
        $this->newEmail = $newEmail;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->subject('Xác minh địa chỉ email mới')
            ->greeting('Xin chào, ' . $notifiable->name . '!')
            ->line('Bạn vừa yêu cầu cập nhật địa chỉ email.')
            ->line('Vui lòng nhấp vào nút bên dưới để xác minh email mới.')
            ->action('Xác minh Email', $verificationUrl)
            ->line('Nếu bạn không yêu cầu thay đổi email, hãy bỏ qua email này.')
            ->salutation('Trân trọng, JamTravelWeb');
    }

    protected function verificationUrl($notifiable)
    {
        return URL::temporarySignedRoute(
            'email.verify.new',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($this->newEmail),
                'email' => $this->newEmail,
            ]
        );
    }
}
