<?php
declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\OfferRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=OfferRepository::class)
 */
class Offer
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private ?float $aggregateRating;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $price;

    /**
     * @ORM\Column(type="string", length=3)
     */
    private ?string $priceCurrency;

    /**
     * @ORM\ManyToMany(targetEntity=Service::class, inversedBy="offers")
     */
    private $itemsOffered;

    public function __construct()
    {
        $this->itemsOffered = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAggregateRating(): ?float
    {
        return $this->aggregateRating;
    }

    public function setAggregateRating(?float $aggregateRating): self
    {
        $this->aggregateRating = $aggregateRating;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getPriceCurrency(): ?string
    {
        return $this->priceCurrency;
    }

    public function setPriceCurrency(string $priceCurrency): self
    {
        $this->priceCurrency = $priceCurrency;

        return $this;
    }

    /**
     * @return Collection|Service[]
     */
    public function getItemsOffered(): Collection
    {
        return $this->itemsOffered;
    }

    public function addItemsOffered(Service $itemsOffered): self
    {
        if (!$this->itemsOffered->contains($itemsOffered)) {
            $this->itemsOffered[] = $itemsOffered;
        }

        return $this;
    }

    public function removeItemsOffered(Service $itemsOffered): self
    {
        if ($this->itemsOffered->contains($itemsOffered)) {
            $this->itemsOffered->removeElement($itemsOffered);
        }

        return $this;
    }
}
