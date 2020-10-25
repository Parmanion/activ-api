<?php

namespace App\Factory;

use App\Entity\Rating;
use App\Repository\RatingRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @method static Rating|Proxy findOrCreate(array $attributes)
 * @method static Rating|Proxy random()
 * @method static Rating[]|Proxy[] randomSet(int $number)
 * @method static Rating[]|Proxy[] randomRange(int $min, int $max)
 * @method static RatingRepository|RepositoryProxy repository()
 * @method Rating|Proxy create($attributes = [])
 * @method Rating[]|Proxy[] createMany(int $number, $attributes = [])
 */
final class RatingFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function getDefaults(): array
    {
        return [
            'author' => UserFactory::new(),
            'ratingExplanation' => self::faker()->boolean(70)?
                self::faker()->paragraphs(self::faker()->numberBetween(1,3), true) : null,
            'ratingValue' => self::faker()->numberBetween(1,5),
            'subjectOf' => OfferFactory::new()
        ];
    }

    protected function initialize(): self
    {
        // see https://github.com/zenstruck/foundry#initialization
        return $this
            // ->afterInstantiate(function(Rating $rating) {})
        ;
    }

    protected static function getClass(): string
    {
        return Rating::class;
    }
}
