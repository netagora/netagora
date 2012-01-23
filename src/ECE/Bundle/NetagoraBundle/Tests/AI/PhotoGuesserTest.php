<?php

namespace ECE\Bundle\NetagoraBundle\Tests\AI;

use ECE\Bundle\NetagoraBundle\AI\PhotoGuesser;

class PhotoGuesserTest extends AbstractGuesserTestCase
{
    /**
     * @dataProvider provideGuesserParameters
     *
     */
    public function testGuess($url, $score)
    {
        $response = $this->getMockResponse();
        $crawler  = $this->getMockCrawler();

        $guesser = new PhotoGuesser($url, $response, $crawler);
        $guesser->guess();

        $this->assertEquals($score, $guesser->getScore());
    }

    public function provideGuesserParameters()
    {
        return array(
            array('http://foo.com/foo/tom.jpg', 0),
            array('http://foo.com/pictures/tom.jpg', 1),
            array('http://foo.com/pictures/tom-img.jpg', 2),
        );
    }
}