<?php

namespace ECE\Bundle\NetagoraBundle\AI;

class MusicGuesser extends AbstractGuesser
{
    public function guess()
    {
        if (preg_match_all('#music|musique|audio|playlist|chanson|song|listen#i', $this->url, $matches) > 0) {
            $this->score += (self::LOW_CONFIDENCE * count($matches[0]));
        }
    }

    public function getName()
    {
        return 'Music';
    }
}