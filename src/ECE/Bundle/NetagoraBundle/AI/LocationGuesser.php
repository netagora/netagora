<?php

namespace ECE\Bundle\NetagoraBundle\AI;

class LocationGuesser extends AbstractGuesser
{
    public function guess()
    {
        if (preg_match_all('#map|foursquare.com|loopt.com|4sq.com#i', $this->url, $matches) > 0) {
            $this->score += count($matches[0]);
        }
    }

    public function getName()
    {
        return 'Location';
    }
}