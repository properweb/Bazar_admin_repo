<?php
use Illuminate\Support\Facades\Mail;

function sendEmail($sender, $recipient, $subject, $view, $data = [])
{
    Mail::send($view, $data, function ($message) use ($sender, $recipient, $subject) {
        $message->from($sender['address'], $sender['name'])
            ->to($recipient)
            ->subject($subject);
    });
}
