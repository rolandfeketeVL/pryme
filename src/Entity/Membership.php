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

    #[ORM\ManyToMany(targetEntity: Benefits::class, inversedBy: 'memberships')]
    private $benefits;

    #[ORM\OneToMany(mappedBy: 'membership', targetEntity: Users::class)]
    private $users;

    #[ORM\Column(type: 'smallint')]
    private $valability;

    #[ORM\OneToMany(mappedBy: 'membership', targetEntity: Event::class)]
    private $events;


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

    /**
     * @return Collection<int, Event>
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(Event $event): self
    {
        if (!$this->events->contains($event)) {
            $this->events[] = $event;
            $event->setMembership($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): self
    {
        if ($this->events->removeElement($event)) {
            // set the owning side to null (unless already changed)
            if ($event->getMembership() === $this) {
                $event->setMembership(null);
            }
        }

        return $this;
    }

}
