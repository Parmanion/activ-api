<?php

namespace App\DataFixtures;

use App\Factory\OfferFactory;
use App\Factory\OrganizationFactory;
use App\Factory\RatingFactory;
use App\Factory\ServiceFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        OrganizationFactory::new()->createMany(5);

        UserFactory::new()->memberOfOrganization()->createMany(15);

        UserFactory::new()->createMany(20);

        OfferFactory::new()->createMany(20);

        ServiceFactory::new()->createMany(20, [
           'offers' => [OfferFactory::random()],
           'provider' => OrganizationFactory::random(),
        ]);

        RatingFactory::new()->createMany(50, [
            'author' => UserFactory::random(),
            'subjectOf' => ServiceFactory::random(),
        ]);
    }
}
