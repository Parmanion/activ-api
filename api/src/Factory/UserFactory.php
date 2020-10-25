<?php
declare(strict_types=1);

namespace App\Factory;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @method static User|Proxy findOrCreate(array $attributes)
 * @method static User|Proxy random()
 * @method static User[]|Proxy[] randomSet(int $number)
 * @method static User[]|Proxy[] randomRange(int $min, int $max)
 * @method static UserRepository|RepositoryProxy repository()
 * @method User|Proxy create($attributes = [])
 * @method User[]|Proxy[] createMany(int $number, $attributes = [])
 */
final class UserFactory extends ModelFactory
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private UserPasswordEncoderInterface $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        parent::__construct();

        $this->passwordEncoder = $passwordEncoder;
    }

    protected function getDefaults(): array
    {
        return [
            'firstName' => self::faker()->firstName,
            'lastName' => self::faker()->lastName,
            'email' => self::faker()->unique()->safeEmail,
            'password' => 'foo',
        ];
    }

    protected function initialize(): self
    {
        return $this
            ->afterInstantiate(function(User $user) {
                    $user->setPassword($this->passwordEncoder->encodePassword($user, $user->getPassword()));
                }
            );
    }

    protected static function getClass(): string
    {
        return User::class;
    }

    public function memberOfOrganization(): self
    {
        return $this->addState(['organization' => OrganizationFactory::random()]);
    }
}
