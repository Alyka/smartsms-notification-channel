<?php

namespace Alyka\SmartSMS\Channels;

use Alyka\SmartSMS\Messages\SmartSMSMessage;
use Alyka\SmartSMS\SmartSMSClient as Client;
use Alyka\SmartSMS\Exceptions\CouldNotSendNotification;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Events\NotificationFailed;

class SmartSMSChannel
{
    /**
     * The SmartSMSClient client instance.
     *
     * @var Client
     */
    protected $client;

    /**
     * Create a new Nexmo channel instance.
     *
     * @param  Client  $client
     * @param  string  $from
     * @return void
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return SmartSMSMessage
     */
    public function send($notifiable, Notification $notification)
    {
		$to = $notifiable->routeNotificationFor('smartSMS');
		
        if (! $to) {
            return;
        }

        $message = $notification->toSmartSMS($notifiable);
		
		$message->to($to);

        if (is_string($message)) {
            $message = new SmartSMSMessage($message);
        }

        try 
		{
            $data = $this->client->send($message);
        } 
		catch (CouldNotSendNotification $e) 
		{
            throw new CouldNotSendNotification($e->getMessage());
        }
		
		return $data;
    }
	
	/**
	 *  @brief Format the given receipient address.
	 *  
	 *  @param string $address
	 *  @return string
	 */
	public function formatAddress($address)
	{
		return str_replace('+', '', $address);
	}
}
