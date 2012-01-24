<?php

namespace ECE\Bundle\NetagoraBundle\AI;

class LocationGuesser extends AbstractGuesser
{
    const PATTERN = '#map|foursquare.com|loopt.com|4sq.com#i';

    public function guess()
    {
        // Url analysis: low confidence
        $this->analyzeUrl(self::PATTERN);

        // Page title analysis: low confidence
        $this->analyzeContentTag('title', self::PATTERN);

        // H1 & H2 analysis: low confidence
        $this->analyzeContentTag('h1', self::PATTERN);
        $this->analyzeContentTag('h2', self::PATTERN);

        // Meta tags analysis: low confidence
        $this->analyzeMetaTag('meta[name="description"]', self::PATTERN);
        $this->analyzeMetaTag('meta[name="og:type"]', self::PATTERN);
        $this->analyzeMetaTag('meta[name="keywords"]', self::PATTERN);
    }

    public function getName()
    {
        return 'Location';
    }
}