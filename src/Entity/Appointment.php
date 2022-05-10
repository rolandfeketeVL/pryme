<?php

namespace App\Entity;

use App\Repository\AppointmentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AppointmentRepository::class)]
class Appointment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Event::class, inversedBy: 'appointments')]
    private $event;

    #[ORM\ManyToOne(targetEntity: Users::class, inversedBy: 'appointments')]
    private $user;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $guestlist;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $position;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(?Event $event): self
    {
        $this->event = $event;

        return $this;
    }

    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(?Users $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getGuestlist(): ?bool
    {
        return $this->guestlist;
    }

    public function setGuestlist(?bool $guestlist): self
    {
        $this->guestlist = $guestlist;

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(?int $position): self
    {
        $this->position = $position;

        return $this;
    }
}
