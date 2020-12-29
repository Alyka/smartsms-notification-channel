<?php

namespace Alyka\SmartSMS;

use Exception;
use GuzzleHttp\Client;
use Alyka\SmartSMS\Messages\SmartSMSMessage;
use Alyka\SmartSMS\Exceptions\CouldNotSendNotification;

class SmartSMSClient
{
    protected 
	
	/**
	 *  Http client instance.
	 *  
	 *  @var Client
	 */
	$client,
	
	/**
	 *  Smart SMS solutions Api token. 
	 *  visit https://smartsmssolutions.com/sms/api-x-tokens
	 *  
	 *  @var string
	 */
	$apiToken,
	
	/**
	 *  Message sender ID.
	 *  
	 *  @var string
	 */
	$from,
	
	/**
	 *  Api endpoint.
	 *  
	 *  @var string
	 */
	$endpoint = 'https://smartsmssolutions.com/api/json.php?';

    /**
     * SmartSMSClient constructor.
     * @param Client $client
     * @param $apiToken string API Key from Messagebird API
     */
    public function __construct(Client $client, $apiToken, $from = null)
    {
        $this->client = $client;
        $this->apiToken = $apiToken;
        $this->from = $from;
    }

    /**
     * Send the Message.
     * @param SmartSMSMessage $message
     * @return
     * @throws CouldNotSendNotification
     */
    public function send(SmartSMSMessage $message)
    {
		$query = collect($message)->toArray();
		$query['token'] = $this->apiToken;
		
		if(! $query['sender'])
		{
			$query['sender'] = $this->from;
		}
		
		$response = $this->client->request('POST', $this->endpoint, [
			'query' => $query,
		]);
		
		$response = json_decode($response->getBody()->__toString());
		
		if($response->code !== '1000' || $response->error === true)
		{
			throw new CouldNotSendNotification($response->comment);
		}
		
		return $response;
    }
}
