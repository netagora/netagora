<?php

namespace ECE\Bundle\NetagoraBundle\Tests\AI;

abstract class AbstractGuesserTestCase extends \PHPUnit_Framework_TestCase
{
    protected function getMockCrawler()
    {
        $mock = $this->getMock('Symfony\Component\DomCrawler\Crawler');

        return $mock;
    }

    protected function getMockResponse()
    {
        $mock = $this->getMock('Buzz\Message\Response');

        return $mock;
    }
}