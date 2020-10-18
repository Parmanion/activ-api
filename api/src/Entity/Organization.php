<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\OrganizationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

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
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"organization:read", "organization:write", "activity:item:get"})
     */
    private ?string $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"organization:read", "organization:write"})
     */
    private ?string $legalEntityIdentifier;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="organization", orphanRemoval=true)
     */
    private ArrayCollection $members;

    /**
     * @ORM\OneToMany(targetEntity=Service::class, mappedBy="organization", orphanRemoval=true)
     */
    private ArrayCollection $services;

    public function __construct()
    {
        $this->members = new ArrayCollection();
        $this->services = new ArrayCollection();
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

    public function getLegalEntityIdentifier(): ?string
    {
        return $this->legalEntityIdentifier;
    }

    public function setLegalEntityIdentifier(string $legalEntityIdentifier): self
    {
        $this->legalEntityIdentifier = $legalEntityIdentifier;

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
    public function getServices(): Collection
    {
        return $this->services;
    }

    public function addService(Service $service): self
    {
        if (!$this->services->contains($service)) {
            $this->services[] = $service;
            $service->setOrganization($this);
        }

        return $this;
    }

    public function removeService(Service $service): self
    {
        if ($this->services->contains($service)) {
            $this->services->removeElement($service);
            // set the owning side to null (unless already changed)
            if ($service->getOrganization() === $this) {
                $service->setOrganization(null);
            }
        }

        return $this;
    }
}
