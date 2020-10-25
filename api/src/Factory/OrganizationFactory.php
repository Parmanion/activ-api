<?php

namespace App\Factory;

use App\Entity\Organization;
use App\Repository\OrganizationRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @method static Organization|Proxy findOrCreate(array $attributes)
 * @method static Organization|Proxy random()
 * @method static Organization[]|Proxy[] randomSet(int $number)
 * @method static Organization[]|Proxy[] randomRange(int $min, int $max)
 * @method static OrganizationRepository|RepositoryProxy repository()
 * @method Organization|Proxy create($attributes = [])
 * @method Organization[]|Proxy[] createMany(int $number, $attributes = [])
 * curl -k -X POST -H "Content-Type: application/json" https://localhost:8443/login -d '{"email":"shirley85@example.net","password":"foo"}'
 */
final class OrganizationFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function getDefaults(): array
    {
        return [
            'name' => self::faker()->name,
            'leiCode' => self::faker()->bankAccountNumber,
        ];
    }

    protected function initialize(): self
    {
        // see https://github.com/zenstruck/foundry#initialization
        return $this
            // ->afterInstantiate(function(Organization $organization) {})
        ;
    }

    protected static function getClass(): string
    {
        return Organization::class;
    }
}
