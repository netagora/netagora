<?php

namespace ECE\Bundle\NetagoraBundle\AI;

class ContentTypeGuesser extends AbstractGuesser
{
    private $contentType;

    public function __construct($contentType)
    {
        parent::__construct();

        $this->contentType = $contentType;
    }

    public function guess()
    {
        $this->guessPhoto();
        $this->guessVideo();
        $this->guessMusic();
        $this->guessLocation();
        $this->guessOther();
    }

    private function guessLocation()
    {
        $pattern = '#map|foursquare.com|loopt.com|4sq.com#i';

        if (preg_match_all($pattern, $this->url, $matches)) {
            $this->incrementScore(static::TYPE_LOCATION, count($matches[0]));
        }
    }

    private function guessMusic()
    {
        $pattern = '#music|musique|audio|playlist|chanson|song|listen#i';

        if (preg_match_all($pattern, $this->url, $matches)) {
            $this->incrementScore(static::TYPE_MUSIC, count($matches[0]));
        }
    }

    private function guessVideo()
    {
        $pattern = '#video|watch|film|trailer|movie#i';

        if (preg_match_all($pattern, $this->url, $matches)) {
            $this->incrementScore(static::TYPE_VIDEO, count($matches[0]));
        }
    }

    private function guessPhoto()
    {
        $pattern = '#image|photo|picture|img#i';

        if (preg_match_all($pattern, $this->url, $matches)) {
            $this->incrementScore(static::TYPE_PHOTO, count($matches[0]));
        }
    }
}