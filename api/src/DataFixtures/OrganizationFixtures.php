<?php
declare(strict_types=1);

namespace App\DataFixtures;

use App\Factory\OrganizationFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class OrganizationFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        OrganizationFactory::new()->createMany(5);
    }
}
