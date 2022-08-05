<?php
namespace App\Listeners;

use App\Models\QueueEmail;

class ManagerSubscribe
{
    public function subscribe($events)
    {
        $events->listen('sendmail.static', function($data){
            $mail = new QueueEmail();
            $mail->title = $data['title'];
            $mail->content = view('mail_templates.' . $data['type'], $data['data'] ?? [])->render();
            $mail->from = config('mail.from.name');
            $mail->to = $data['email'];
            $mail->status = 0;
            $mail->is_sms = $data['isSms'] ?? null;
            $mail->bcc = null;
            $mail->cc = null;
            $mail->save();
        });
    }
}