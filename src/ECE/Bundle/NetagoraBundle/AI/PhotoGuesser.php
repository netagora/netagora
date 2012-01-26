<?php

namespace ECE\Bundle\NetagoraBundle\AI;

class PhotoGuesser extends AbstractGuesser
{
    const PATTERN = '#image|photo|picture|img#i';

    public function guess()
    {
        // Url analysis: low confidence
        $this->analyzeUrl(self::PATTERN);

        // Check the response content type: medium confidence
        if (preg_match('#image/(jpe?g|png|gif)#i', $this->response->getHeader('Content-Type'))) {
            $this->score += self::HIGH_CONFIDENCE;
        }

        // Check the image type: high confidence
        $infos = @getimagesize($this->url);
        if (is_array($infos) && in_array($infos[2], array(IMG_GIF, IMG_PNG, IMG_JPG, IMG_JPEG))) {
            $this->score += self::HIGH_CONFIDENCE;
        }

        // Page title analysis: low confidence
        $this->analyzeContentTag('title', self::PATTERN);

        // h1 & h2 analysis: low confidence
        $this->analyzeContentTag('h1', self::PATTERN);
        $this->analyzeContentTag('h2', self::PATTERN);

        // Meta tags analysis: low confidence
        $this->analyzeMetaTag('meta[name="description"]', self::PATTERN);
        $this->analyzeMetaTag('meta[name="og:type"]', self::PATTERN);
        $this->analyzeMetaTag('meta[name="keywords"]', self::PATTERN);
    }

    public function getName()
    {
        return 'Photo';
    }
}