<?php

namespace ECE\Bundle\NetagoraBundle\AI;

class MusicGuesser extends AbstractGuesser
{
    const PATTERN = '#music|musique|audio|playlist|chanson|song|listen#i';

    public function guess()
    {
        // Url analysis: low confidence
        $this->analyzeUrl(self::PATTERN);

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
        return 'Music';
    }
}