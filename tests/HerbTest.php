<?php

namespace App\Tests;

use App\Entity\Herb;
use PHPUnit\Framework\TestCase;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ObjectRepository;

class HerbTest extends TestCase
{
    public function testCreateHerb(): void
    {
        $herb = new Herb();
        $herb->setName("testHerb");
        $herb->setDescription(("testDescription"));

        $this->assertSame('testHerb', $herb->getName());
        $this->assertSame('testDescription', $herb->getDescription());
    }
}
