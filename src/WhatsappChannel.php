<?php


namespace MichelMelo\WhatsappNotify;


use Illuminate\Notifications\Notification;

class WhatsappChannel
{
    /**
     * @param $notifiable
     * @param Notification $notification
     */
    public function send($notifiable, Notification $notification)
    {

        if (!$phone = $notifiable->routeNotificationFor('whatsapp', $notification)) {
            return;
        }
        $data = $notification->toWhatsapp($notifiable);
        WhatsappNotifyFacade::send($phone , $data['message']);
    }
}
