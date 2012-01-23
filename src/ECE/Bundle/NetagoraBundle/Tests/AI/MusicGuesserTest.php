<?php

namespace ECE\Bundle\NetagoraBundle\Tests\AI;

use ECE\Bundle\NetagoraBundle\AI\MusicGuesser;

class MusicGuesserTest extends AbstractGuesserTestCase
{
    /**
     * @dataProvider provideGuesserParameters
     *
     */
    public function testGuess($url, $score)
    {
        $response = $this->getMockResponse();
        $crawler  = $this->getMockCrawler();

        $guesser = new MusicGuesser($url, $response, $crawler);
        $guesser->guess();

        $this->assertEquals($score, $guesser->getScore());
    }

    public function provideGuesserParameters()
    {
        return array(
            array('http://foo.com/foo/lol.mp3', 0),
            array('http://foo.com/listen/lol.mp3', 1),
            array('http://foo.com/listen/lol-music.mp3', 2),
        );
    }
}