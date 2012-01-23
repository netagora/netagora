<?php

namespace ECE\Bundle\NetagoraBundle\AI;

class VideoGuesser extends AbstractGuesser
{
    public function guess()
    {
        if (preg_match_all('#video|watch|film|trailer|movie#i', $this->url, $matches) > 0) {
            $this->score += count($matches[0]);
        }
    }

    public function getName()
    {
        return 'Video';
    }
}