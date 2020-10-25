<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\OrganizationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     shortName="organizations",
 *     normalizationContext={"groups"={"organization:read"}, "swagger_definition_name"="read"},
 *     denormalizationContext={"groups"={"organization:write"}, "swagger_definition_name"="write"}
 * )
 * @ORM\Entity(repositoryClass=OrganizationRepository::class)
 */
class Organization
{
    use TimestampableEntity;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"organization:read", "organization:write", "activity:item:get"})
     * @Assert\NotBlank
     */
    private ?string $name;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="organization", orphanRemoval=true)
     */
    private Collection $members;

    /**
     * @ORM\OneToMany(targetEntity=Service::class, mappedBy="provider")
     */
    private Collection $makesOffer;

    /**
     * Legal entity identifier as defined in ISO 17442
     * @ORM\Column(type="string", length=255)
     * @Groups({"organization:read", "organization:write"})
     * @Assert\NotBlank
     */
    private ?string $leiCode;

    public function __construct()
    {
        $this->members = new ArrayCollection();
        $this->makesOffer = new ArrayCollection();
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

    /**
     * @return Collection|User[]
     */
    public function getMembers(): Collection
    {
        return $this->members;
    }

    public function addMember(User $member): self
    {
        if (!$this->members->contains($member)) {
            $this->members[] = $member;
            $member->setOrganization($this);
        }

        return $this;
    }

    public function removeMember(User $member): self
    {
        if ($this->members->contains($member)) {
            $this->members->removeElement($member);
            // set the owning side to null (unless already changed)
            if ($member->getOrganization() === $this) {
                $member->setOrganization(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Service[]
     */
    public function getMakesOffer(): Collection
    {
        return $this->makesOffer;
    }

    public function addMakesOffer(Service $makesOffer): self
    {
        if (!$this->makesOffer->contains($makesOffer)) {
            $this->makesOffer[] = $makesOffer;
            $makesOffer->setProvider($this);
        }

        return $this;
    }

    public function removeMakesOffer(Service $makesOffer): self
    {
        if ($this->makesOffer->contains($makesOffer)) {
            $this->makesOffer->removeElement($makesOffer);
            // set the owning side to null (unless already changed)
            if ($makesOffer->getProvider() === $this) {
                $makesOffer->setProvider(null);
            }
        }

        return $this;
    }

    public function getLeiCode(): ?string
    {
        return $this->leiCode;
    }

    public function setLeiCode(string $leiCode): self
    {
        $this->leiCode = $leiCode;

        return $this;
    }
}
