<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail as BaseVerifyEmail;

class CustomVerifyEmail extends BaseVerifyEmail
{
    protected function verificationUrl($notifiable)
    {
        // Generate a signed URL with a custom redirect to Nuxt3
        return config('app.frontend_url') . '/verify?url=' . urlencode(parent::verificationUrl($notifiable));
    }
}
