<?php

namespace ECE\Bundle\NetagoraBundle\AI;

class PhotoGuesser extends AbstractGuesser
{
    public function guess()
    {
        if (preg_match_all('#image|photo|picture|img#i', $this->url, $matches) > 0) {
            $this->score += count($matches[0]);
        }
    }

    public function getName()
    {
        return 'Photo';
    }
}