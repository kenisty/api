<?php declare(strict_types=1);

namespace App\Entity;

use App\Repository\SectRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Stringable;

#[ORM\Entity(repositoryClass: SectRepository::class)]
class Sect implements Stringable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: false)]
    private ?string $name = null;

    /** @var Collection<int, Church> $churches */
    #[ORM\OneToMany(mappedBy: 'sect', targetEntity: Church::class)]
    private Collection $churches;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: false)]
    private ?DateTimeImmutable $createdAt = null;

    public function __construct()
    {
        $this->churches = new ArrayCollection();
    }

    public function __toString(): string
    {
        return sprintf("Sect #%s", $this->id);
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
     * @return Collection<int, Church>
     */
    public function getChurches(): Collection
    {
        return $this->churches;
    }

    public function addChurch(Church $church): self
    {
        if (!$this->churches->contains($church)) {
            $this->churches->add($church);
            $church->setSect($this);
        }

        return $this;
    }

    public function removeChurch(Church $church): self
    {
        if ($this->churches->removeElement($church)) {
            if ($church->getSect() === $this) {
                $church->setSect(null);
            }
        }

        return $this;
    }

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
