<?php
declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ServiceRepository;
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
     * @ORM\ManyToOne(targetEntity=Organization::class, inversedBy="services")
     * @ORM\JoinColumn(nullable=false)
     */
    private ?Organization $organization;

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

    public function getOrganization(): ?Organization
    {
        return $this->organization;
    }

    public function setOrganization(?Organization $organization): self
    {
        $this->organization = $organization;

        return $this;
    }
}
