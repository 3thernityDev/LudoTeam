<?php

namespace App\DataFixtures;

use App\Factory\GameFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        GameFactory::new()->createMany(10);

        $manager->flush();
    }
}
