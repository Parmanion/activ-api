<?php


namespace App\Tests\Functional;


use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;

class OrganizationTest extends ApiTestCase
{
    public function testCreateOrganization()
    {
        $client = self::createClient();
        $client->request('POST', '/organizations');

        $this->assertResponseStatusCodeSame(401);
    }

}
