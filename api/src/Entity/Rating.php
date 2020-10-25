<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\RatingRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=RatingRepository::class)
 */
class Rating
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="ratings")
     * @ORM\JoinColumn(nullable=false)
     */
    private ?User $author;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $ratingExplanation;

    /**
     * @ORM\Column(type="smallint")
     */
    private ?int $ratingValue;

    /**
     * @ORM\ManyToOne(targetEntity=Service::class, inversedBy="ratings")
     * @ORM\JoinColumn(nullable=false)
     */
    private ?Service $subjectOf;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getRatingExplanation(): ?string
    {
        return $this->ratingExplanation;
    }

    public function setRatingExplanation(?string $ratingExplanation): self
    {
        $this->ratingExplanation = $ratingExplanation;

        return $this;
    }

    public function getRatingValue(): ?int
    {
        return $this->ratingValue;
    }

    public function setRatingValue(int $ratingValue): self
    {
        $this->ratingValue = $ratingValue;

        return $this;
    }

    public function getSubjectOf(): ?Service
    {
        return $this->subjectOf;
    }

    public function setSubjectOf(?Service $subjectOf): self
    {
        $this->subjectOf = $subjectOf;

        return $this;
    }
}
