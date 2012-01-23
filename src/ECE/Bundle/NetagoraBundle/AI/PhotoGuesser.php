<?php

namespace ECE\Bundle\NetagoraBundle\AI;

class PhotoGuesser extends AbstractGuesser
{
    public function guess()
    {
        // Check the image url: low confidence
        if (preg_match_all('#image|photo|picture|img#i', $this->url, $matches) > 0) {
            $this->score += (self::LOW_CONFIDENCE * count($matches[0]));
        }

        // Check the response content type: medium confidence
        if (preg_match('#image/(jpe?g|png|gif)#i', $this->response->getHeader('Content-Type'))) {
            $this->score += self::MEDIUM_CONFIDENCE;
        }

        // Check the image type: high confidence
        $infos = @getimagesize($this->url);
        if (is_array($infos) && in_array($infos[2], array(IMG_GIF, IMG_PNG, IMG_JPG, IMG_JPEG))) {
            $this->score += self::HIGH_CONFIDENCE;
        }
    }

    public function getName()
    {
        return 'Photo';
    }
}