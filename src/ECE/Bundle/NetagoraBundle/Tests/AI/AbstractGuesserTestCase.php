<?php

namespace ECE\Bundle\NetagoraBundle\Tests\AI;

use Symfony\Component\DomCrawler\Crawler;

abstract class AbstractGuesserTestCase extends \PHPUnit_Framework_TestCase
{
    protected function getMockCrawler()
    {
        return new Crawler();
    }

    protected function getMockResponse()
    {
        $mock = $this->getMock('Buzz\Message\Response');

        return $mock;
    }
}