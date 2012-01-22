<?php

namespace ECE\Bundle\NetagoraBundle\Social\Twitter;

use TwitterOAuth;

class TwitterApi
{
    private $twitter;
    private $parameters;

    public function __construct(TwitterOAuth $twitter)
    {
        $this->twitter = $twitter;
        $this->parameters = array();
    }

    public function setOAuthToken($token, $secret)
    {
        $this->twitter->setOAuthToken($token, $secret);
    }

    public function setScreenName($name)
    {
        $this->parameters['screen_name'] = $name;
    }

    public function setSinceId($reference)
    {
        $this->parameters['since_id'] = $reference;
    }

    public function getHomeTimeline(array $parameters = array())
    {
        return $this->twitter->get('statuses/home_timeline', array_merge(
            $this->parameters,
            $parameters
        ));
    }
}