<?php

namespace ECE\Bundle\NetagoraBundle\AI;

use Buzz\Message\Response;
use Symfony\Component\DomCrawler\Crawler;

abstract class AbstractGuesser implements GuesserStrategyInterface
{
    const LOW_CONFIDENCE = 1;
    const MEDIUM_CONFIDENCE = 5;
    const HIGH_CONFIDENCE = 10;

    protected $score;
    protected $url;
    protected $response;
    protected $crawler;

    public function __construct($url, Response $response, Crawler $crawler)
    {
        $this->score = 0;
        $this->response = $response;
        $this->crawler = $crawler;
        $this->url = $url;
    }

    public function getScore()
    {
        return $this->score;
    }

    public function getMetadata()
    {
        return $this->metadata;
    }

    protected function analyzeUrl($pattern, $confidence = self::LOW_CONFIDENCE)
    {
        if (preg_match_all($pattern, $this->url, $matches) > 0) {
            $this->score += ($confidence * count($matches[0]));
        }
    }

    protected function analyzeContentTag($selector, $pattern = null, $confidence = self::LOW_CONFIDENCE)
    {
        $results = array();
        $filter = function ($node, $i) use ($selector, $pattern, $confidence, &$results) {
            $content = (string) $node->nodeValue;
            $results[] = $content;
            if (null !== $pattern && preg_match_all($pattern, $content, $matches) > 0) {
                $this->scores += ($confidence * count($matches[0]));
            }
        };

        $this->crawler->filter($selector)->each($filter);

        return $results;
    }

    protected function analyzeMetaTag($selector, $pattern = null, $confidence = self::LOW_CONFIDENCE)
    {
        $content = '';
        $crawler = $this->crawler->filter($selector);

        if ($crawler->count() > 0) {
            $content = $crawler->node(0)->attr('content');
        }

        if (!empty($content) && null !== $pattern) {
            if (preg_match_all($pattern, $content, $matches) > 0) {
                $this->score += ($confidence * count($matches[0]));
            }
        }

        return $content;
    }
}