<?php

namespace ECE\Bundle\NetagoraBundle\AI;

use Buzz\Message\Response;
use Symfony\Component\DomCrawler\Crawler;

class CategoryGuesser extends AbstractGuesser
{
    private $guessers;
    private $scores;

    public function __construct($url, Response $response, Crawler $crawler)
    {
        parent::__construct($url, $response, $crawler);

        $this->scores   = array();

        $this
            ->addGuesser(new PhotoGuesser($url, $response, $crawler))
            ->addGuesser(new MusicGuesser($url, $response, $crawler))
            ->addGuesser(new VideoGuesser($url, $response, $crawler))
            ->addGuesser(new LocationGuesser($url, $response, $crawler))
        ;
    }

    public function getName()
    {
        return 'Category';
    }

    public function getMetadata()
    {
        return array(
            'url' => $this->url,
            'meta_description' => $this->analyzeMetaTag('meta[name="description"]'),
            'meta_keywords' => $this->analyzeMetaTag('meta[name="keywords"]'),
            'title' => current($this->analyzeContentTag('title')),
            'h1' => current($this->analyzeContentTag('h1')),
            'h2' => current($this->analyzeContentTag('h2')),
        );
    }

    // Returns the highest score
    public function getScore()
    {
        return max($this->scores);
    }

    public function getCategory($default = 'Other')
    {
        $keys = array_keys($this->scores, $this->getScore());

        // Equalty, so Other by default
        if (0 === count($keys) || count($keys) > 1) {
            return $default;
        }

        // The category (guesser name) whose score is the highest among others.
        return current($keys);
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
            $this->scores[$guesser->getName()] = $guesser->getScore();
        }
    }

    public function getScores()
    {
        return $this->scores;
    }
}