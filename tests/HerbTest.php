<?php

namespace App\Tests;

use App\Entity\Herb;
use App\Repository\HerbRepository;
use PHPUnit\Framework\TestCase;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class HerbTest extends KernelTestCase
{
    public function testWorkflow(): void
    {
        $kernel = self::bootKernel();

        $em = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        //--------------CREATE--------------------
        $herb = new Herb();
        $herb->setName("testHerb");
        $herb->setDescription(("testDescription"));

        $em->persist($herb);
        $em->flush();

        $newHerb = $em->getRepository(Herb::class)
            ->findOneBy(['name' => 'testHerb']);

        $this->assertEquals($herb->getName(), $newHerb->getName());

        //--------------UPDATE--------------------
        $herb->setName("updatedHerb");
        $em->persist($herb);
        $em->flush();

        //Get updated
        $newHerb = $em->getRepository(Herb::class)
            ->findOneBy(['name' => 'updatedHerb']);

        $this->assertEquals($herb->getName(), $newHerb->getName());

        //--------------DELETE--------------------
        $em->remove($herb);
        $em->flush();

        $newHerb = $em->getRepository(Herb::class)
            ->findOneBy(['name' => 'updatedHerb']);

        $this->assertNull($newHerb);
    }

    public function testCreateHerb(): void
    {
        $kernel = self::bootKernel();

        $em = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        $herb = new Herb();
        $herb->setName("testHerb");
        $herb->setDescription(("testDescription"));

        $em->persist($herb);
        $em->flush();

        $newHerb = $em->getRepository(Herb::class)
            ->findOneBy(['name' => 'testHerb']);

        $this->assertEquals($herb->getName(), $newHerb->getName());
    }

    public function testUpdateHerb(): void
    {
        $kernel = self::bootKernel();

        $em = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        //Update Herb
        $herb = $em->getRepository(Herb::class)
            ->findOneBy(['name' => 'testHerb']);

        $herb->setName("updatedHerb");
        $em->persist($herb);
        $em->flush();

        //Get updated
        $newHerb = $em->getRepository(Herb::class)
            ->findOneBy(['name' => 'updatedHerb']);

        $this->assertEquals($herb->getName(), $newHerb->getName());
    }

    public function testDeleteHerb(): void
    {
        $kernel = self::bootKernel();

        $em = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        //Find herb Herb
        $herb = $em->getRepository(Herb::class)
            ->findOneBy(['name' => 'updatedHerb']);

        //Remove it
        $em->remove($herb);
        $em->flush();

        //Check if it exists
        $newHerb = $em->getRepository(Herb::class)
            ->findOneBy(['name' => 'updatedHerb']);

        $this->assertNull($newHerb);
    }
}
