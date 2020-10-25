<?php

namespace App\Factory;

use App\Entity\Service;
use App\Repository\ServiceRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @method static Service|Proxy findOrCreate(array $attributes)
 * @method static Service|Proxy random()
 * @method static Service[]|Proxy[] randomSet(int $number)
 * @method static Service[]|Proxy[] randomRange(int $min, int $max)
 * @method static ServiceRepository|RepositoryProxy repository()
 * @method Service|Proxy create($attributes = [])
 * @method Service[]|Proxy[] createMany(int $number, $attributes = [])
 */
final class ServiceFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();

        // TODO inject services if required (https://github.com/zenstruck/foundry#factories-as-services)
    }

    protected function getDefaults(): array
    {
        return [
            'name' => self::faker()->realText(50),
            'description' => self::faker()->paragraphs(self::faker()->numberBetween(2,4), true),
            'provider' => OrganizationFactory::new()
        ];
    }

    protected function initialize(): self
    {
        // see https://github.com/zenstruck/foundry#initialization
        return $this
            // ->afterInstantiate(function(Service $service) {})
        ;
    }

    protected static function getClass(): string
    {
        return Service::class;
    }
}
