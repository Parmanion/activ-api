<?php
declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ServiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     itemOperations={
 *          "get"={
 *              "normalization_context"={
 *                  "groups"={
 *                      "activity:read",
 *                      "activity:item:get"
 *                  }
 *              }
 *          }
 *     },
 *     shortName="services",
 *     normalizationContext={"groups"={"service:read"}, "swagger_definition_name"="read"},
 *     denormalizationContext={"groups"={"service:write"}, "swagger_definition_name"="write"}
 * )
 * @ORM\Entity(repositoryClass=ServiceRepository::class)
 */
class Service
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"activity:read", "activity:write"})
     */
    private ?string $name;

    /**
     * @ORM\Column(type="text")
     * @Groups({"activity:read", "activity:write"})
     */
    private ?string $description;

    /**
     * @ORM\OneToMany(targetEntity=Rating::class, mappedBy="subjectOf")
     */
    private $ratings;

    /**
     * @ORM\ManyToOne(targetEntity=Organization::class, inversedBy="makesOffer")
     * @ORM\JoinColumn(nullable=false)
     */
    private $provider;

    /**
     * @ORM\ManyToMany(targetEntity=Offer::class, mappedBy="itemsOffered")
     */
    private $offers;

    public function __construct()
    {
        $this->ratings = new ArrayCollection();
        $this->offers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|Rating[]
     */
    public function getRatings(): Collection
    {
        return $this->ratings;
    }

    public function addRating(Rating $rating): self
    {
        if (!$this->ratings->contains($rating)) {
            $this->ratings[] = $rating;
            $rating->setSubjectOf($this);
        }

        return $this;
    }

    public function removeRating(Rating $rating): self
    {
        if ($this->ratings->contains($rating)) {
            $this->ratings->removeElement($rating);
            // set the owning side to null (unless already changed)
            if ($rating->getSubjectOf() === $this) {
                $rating->setSubjectOf(null);
            }
        }

        return $this;
    }

    public function getProvider(): ?Organization
    {
        return $this->provider;
    }

    public function setProvider(?Organization $provider): self
    {
        $this->provider = $provider;

        return $this;
    }

    /**
     * @return Collection|Offer[]
     */
    public function getOffers(): Collection
    {
        return $this->offers;
    }

    public function addOffer(Offer $offer): self
    {
        if (!$this->offers->contains($offer)) {
            $this->offers[] = $offer;
            $offer->addItemsOffered($this);
        }

        return $this;
    }

    public function removeOffer(Offer $offer): self
    {
        if ($this->offers->contains($offer)) {
            $this->offers->removeElement($offer);
            $offer->removeItemsOffered($this);
        }

        return $this;
    }
}
