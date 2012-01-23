<?php

namespace ECE\Bundle\NetagoraBundle\AI;

use Buzz\Message\Response;
use Symfony\Component\DomCrawler\Crawler;

abstract class AbstractGuesser implements GuesserStrategyInterface
{
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

    /*protected function guessOther()
    {
        if (0 === array_sum($this->scores)) {
            $this->resetScores();
            $this->incrementScore(static::TYPE_OTHER);
            return;
        }

        $max = max($this->scores);
        $values = array_count_values($this->scores);
        // Check for an equalty
        if ($values[$max] > 1) {
            $this->resetScores();
            $this->incrementScore(static::TYPE_OTHER);
        }
    }*/
}