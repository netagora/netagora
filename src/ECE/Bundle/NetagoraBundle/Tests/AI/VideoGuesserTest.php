<?php

namespace ECE\Bundle\NetagoraBundle\Tests\AI;

use ECE\Bundle\NetagoraBundle\AI\VideoGuesser;

class VideoGuesserTest extends AbstractGuesserTestCase
{
    /**
     * @dataProvider provideGuesserParameters
     *
     */
    public function testGuess($url, $score)
    {
        $response = $this->getMockResponse();
        $crawler  = $this->getMockCrawler();

        $guesser = new VideoGuesser($url, $response, $crawler);
        $guesser->guess();

        $this->assertEquals($score, $guesser->getScore());
    }

    public function provideGuesserParameters()
    {
        return array(
            array('http://foo.com/foo/tom.avi', 0),
            array('http://foo.com/watch/tom.avi', 1),
            array('http://foo.com/watch/trailer/tom.avi', 2),
        );
    }
}