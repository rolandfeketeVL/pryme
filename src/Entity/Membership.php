<?php

namespace App\Entity;

use App\Repository\MembershipRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MembershipRepository::class)]
class Membership
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'smallint')]
    private $credits;

    #[ORM\Column(type: 'smallint')]
    private $price;

    #[ORM\Column(type: 'datetime')]
    private $valability;

    #[ORM\Column(type: 'smallint')]
    private $persons_no;

    #[ORM\Column(type: 'smallint')]
    private $minutes;

    #[ORM\ManyToMany(targetEntity: Benefits::class, inversedBy: 'memberships')]
    private $benefits;

    public function __construct()
    {
        $this->benefits = new ArrayCollection();
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

    public function getCredits(): ?int
    {
        return $this->credits;
    }

    public function setCredits(int $credits): self
    {
        $this->credits = $credits;

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

    public function getValability(): ?\DateTimeInterface
    {
        return $this->valability;
    }

    public function setValability(\DateTimeInterface $valability): self
    {
        $this->valability = $valability;

        return $this;
    }

    public function getPersonsNo(): ?int
    {
        return $this->persons_no;
    }

    public function setPersonsNo(int $persons_no): self
    {
        $this->persons_no = $persons_no;

        return $this;
    }

    public function getMinutes(): ?int
    {
        return $this->minutes;
    }

    public function setMinutes(int $minutes): self
    {
        $this->minutes = $minutes;

        return $this;
    }

    /**
     * @return Collection<int, Benefits>
     */
    public function getBenefits(): Collection
    {
        return $this->benefits;
    }

    public function addBenefit(Benefits $benefit): self
    {
        if (!$this->benefits->contains($benefit)) {
            $this->benefits[] = $benefit;
        }

        return $this;
    }

    public function removeBenefit(Benefits $benefit): self
    {
        $this->benefits->removeElement($benefit);

        return $this;
    }

}
