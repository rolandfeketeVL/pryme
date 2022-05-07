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

    #[ORM\Column(type: 'smallint')]
    private $persons_no;

    #[ORM\Column(type: 'smallint')]
    private $minutes;

    #[ORM\OneToMany(mappedBy: 'membership', targetEntity: Users::class)]
    private $users;

    #[ORM\Column(type: 'smallint')]
    private $valability;

    #[ORM\ManyToOne(targetEntity: MembershipGroup::class, inversedBy: 'memberships')]
    private $membershipGroup;


    public function __construct()
    {
        $this->benefits = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->events = new ArrayCollection();
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
     * @return Collection<int, Users>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(Users $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setMembership($this);
        }

        return $this;
    }

    public function removeUser(Users $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getMembership() === $this) {
                $user->setMembership(null);
            }
        }

        return $this;
    }

    public function getValability(): ?int
    {
        return $this->valability;
    }

    public function setValability(int $valability): self
    {
        $this->valability = $valability;

        return $this;
    }

    public function getMembershipGroup(): ?MembershipGroup
    {
        return $this->membershipGroup;
    }

    public function setMembershipGroup(?MembershipGroup $membershipGroup): self
    {
        $this->membershipGroup = $membershipGroup;

        return $this;
    }

}
