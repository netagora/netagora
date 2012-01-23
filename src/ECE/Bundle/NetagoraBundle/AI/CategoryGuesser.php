<?php

namespace ECE\Bundle\NetagoraBundle\AI;

use Buzz\Message\Response;
use Symfony\Component\DomCrawler\Crawler;

class CategoryGuesser
{
    private $url;
    private $response;
    private $guessers;
    private $scores;

    public function __construct($url, Response $response, Crawler $crawler)
    {
        $this->url = $url;
        $this->response = $response;
        $this->scores = array();

        $this
            ->addGuesser(new PhotoGuesser($url, $response, $crawler))
            ->addGuesser(new MusicGuesser($url, $response, $crawler))
            ->addGuesser(new VideoGuesser($url, $response, $crawler))
            ->addGuesser(new LocationGuesser($url, $response, $crawler))
        ;
    }

    public function addGuesser(GuesserStrategyInterface $guesser)
    {
        $this->guessers[] = $guesser;

        return $this;
    }

    public function guess()
    {
        foreach ($this->guessers as $guesser) {
            $guesser->guess();
        }
    }

    public function getScores()
    {
        foreach ($this->guessers as $guesser) {
            $this->scores[$guesser->getName()] = $this->getScore();
        }
    }
}