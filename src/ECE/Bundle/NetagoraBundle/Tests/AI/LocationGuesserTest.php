<?php

namespace ECE\Bundle\NetagoraBundle\Tests\AI;

use ECE\Bundle\NetagoraBundle\AI\LocationGuesser;

class LocationGuesserTest extends AbstractGuesserTestCase
{
    /**
     * @dataProvider provideGuesserParameters
     *
     */
    public function testGuess($url, $score)
    {
        $response = $this->getMockResponse();
        $crawler  = $this->getMockCrawler();

        $guesser = new LocationGuesser($url, $response, $crawler);
        $guesser->guess();

        $this->assertEquals($score, $guesser->getScore());
    }

    public function provideGuesserParameters()
    {
        return array(
            array('http://foo.com/foo/tom.avi', 0),
            array('http://foursquare.com/42', 1),
            array('http://map.foursquare.com/42', 2),
        );
    }
}