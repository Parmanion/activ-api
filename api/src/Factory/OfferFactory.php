<?php

namespace App\Factory;

use App\Entity\Offer;
use App\Repository\OfferRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @method static Offer|Proxy findOrCreate(array $attributes)
 * @method static Offer|Proxy random()
 * @method static Offer[]|Proxy[] randomSet(int $number)
 * @method static Offer[]|Proxy[] randomRange(int $min, int $max)
 * @method static OfferRepository|RepositoryProxy repository()
 * @method Offer|Proxy create($attributes = [])
 * @method Offer[]|Proxy[] createMany(int $number, $attributes = [])
 */
final class OfferFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function getDefaults(): array
    {
        return [
            'aggregateRating' => self::faker()->numberBetween(1, 5),
            'price' => self::faker()->numberBetween(1500, 20000),
            'priceCurrency' => self::faker()->currencyCode,
        ];
    }

    protected function initialize(): self
    {
        // see https://github.com/zenstruck/foundry#initialization
        return $this
            // ->afterInstantiate(function(Offer $offer) {})
        ;
    }

    protected static function getClass(): string
    {
        return Offer::class;
    }
}
