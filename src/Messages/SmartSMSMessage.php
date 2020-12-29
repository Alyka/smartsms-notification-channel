<?php

namespace Alyka\SmartSMS\Messages;

class SmartSMSMessage
{
    /**
     * The message content.
     *
     * @var string
     */
    public $message;

    /**
     * The sender id.
     *
     * @var string
     */
    public $sender;
	
	/**
     * The receipient phone number.
     *
     * @var string
     */
    public $to;

    /**
     * The message type.
     *
     * @var int
     */
    public $type = 0;
	
	/**
     * The message route.
     *
     * @var int
     */
    public $routing = 3; // use corporate route for dnd numbers and normal route for non-dnd numbers.

    /**
     * Create a new message instance.
     *
     * @param  string  $content
     * @return void
     */
    public function __construct($message = '')
    {
        $this->message = $message;
    }

    /**
     * Set the message content.
     *
     * @param  string  $content
     * @return $this
     */
    public function message($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Set the phone number the message should be sent from.
     *
     * @param  string  $from
     * @return $this
     */
    public function from($from)
    {
        $this->sender = $from;

        return $this;
    }
	
	/**
     * Set the receipient phone number.
     *
     * @param  string  $to
     * @return $this
     */
    public function to($to)
    {
        $this->to = $to;

        return $this;
    }

    /**
     * Set the message route.
     *
     * @return $this
     */
    public function route($route)
    {
        $this->routing = $route;

        return $this;
    }
	
	/**
     * Set the message type.
     *
     * @return $this
     */
    public function type($type)
    {
        $this->type = $type;

        return $this;
    }
}
