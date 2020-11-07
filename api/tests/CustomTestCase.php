<?php


namespace App\Tests;


use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\Client;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;
use Zenstruck\Foundry\Test\Factories;

class CustomTestCase extends ApiTestCase
{
    use ReloadDatabaseTrait;
    use Factories;

    protected function createUser(string $email, string $password): User
    {
        $user = new User();
        $user->setEmail($email);
        $user->setFirstName('Druss');
        $user->setLastName('Snaga');

        $encoded = self::$container->get('security.password_encoder')
                                   ->encodePassword($user, $password);
        $user->setPassword($encoded);

        $em = self::$container->get('doctrine')->getManager();
        $em->persist($user);
        $em->flush();

        return $user;
    }

    protected function logIn(Client $client, string $email, string $password)
    {
        $response = $client->request('POST', '/login', [
            'json' => [
                'email' => $email,
                'password' => $password
            ],
        ]);
        self::assertResponseStatusCodeSame(200);
    }

    protected function createUserAndLogIn(Client $client, string $email, string $password): User
    {
        $user = $this->createUser($email, $password);

        $this->logIn($client, $email, $password);

        return $user;
    }

    protected function getEntityManager(): EntityManagerInterface
    {
        return self::$container->get('doctrine')->getManager();
    }

}
