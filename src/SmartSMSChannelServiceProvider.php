<?php

namespace Alyka\SmartSMS;

use GuzzleHttp\Client as HttpClient;
use Alyka\SmartSMS\SmartSMSClient;
use Alyka\SmartSMS\Channels\SmartSMSChannel;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\ServiceProvider;
use Illuminate\Notifications\ChannelManager;

class SmartSMSChannelServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        Notification::resolved(function (ChannelManager $service) {
            $service->extend('smartSMS', function ($app) {
				$client = $this->client($app);
                return new SmartSMSChannel($client);
            });
        });
		
		$this->app->bind('smartSMS', function($app){
			$client = $this->client($app);
			return new SmartSMSChannel($client);
		});
    }
	
	/**
	 *  @brief Get the SmartSMSClient instance.
	 *  
	 *  @param $app
	 *  @return SmartSMSClient
	 */
	protected function client($app)
	{
		return new SmartSMSClient(
			$app->make(HttpClient::class),
			$app['config']['services.smart_sms.api_token'],
			$app['config']['services.smart_sms.sender_id']
		);
	}
}
