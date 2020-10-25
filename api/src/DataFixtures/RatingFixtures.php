<?php
declare(strict_types=1);

namespace App\DataFixtures;

use App\Factory\RatingFactory;
use App\Factory\ServiceFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RatingFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // Pre-create Services and Users and choose randomly
        ServiceFactory::new()->many(5)->create();
        UserFactory::new()->many(10);

        RatingFactory::new()->createMany(30, [
                'author' => UserFactory::random(),
                'subjectOf' => ServiceFactory::random()
            ]
        );
    }
}
