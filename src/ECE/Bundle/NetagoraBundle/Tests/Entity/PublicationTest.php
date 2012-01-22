<?php

namespace ECE\Bundle\NetagoraBundle\Tests\Entity;

use ECE\Bundle\NetagoraBundle\Entity\Publication;

class PublicationTest extends \PHPUnit_Framework_TestCase
{
    public function testFavoriteStatus()
    {
        $publication = new Publication();
        $this->assertFalse($publication->isFavorite());

        $publication->changeFavoriteStatus();
        $this->assertTrue($publication->isFavorite());

        $publication->changeFavoriteStatus();
        $this->assertFalse($publication->isFavorite());
    }
}