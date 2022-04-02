<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class Users implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private $email;

    #[ORM\Column(type: 'json')]
    private $roles = [];

    #[ORM\Column(type: 'string')]
    private $password;

    #[ORM\Column(type: 'string', length: 255)]
    private $firstName;

    #[ORM\Column(type: 'string', length: 255)]
    private $lastName;

    #[ORM\Column(type: 'string', length: 255)]
    private $phone;

    #[ORM\Column(type: 'smallint')]
    private $gender;

    #[ORM\Column(type: 'date', nullable: true)]
    private $birthdate;

    #[ORM\Column(type: 'string', length: 255)]
    private $street;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $state;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $city;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $country;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $zip;

    #[ORM\Column(type: 'integer')]
    private $totalBookings;

    #[ORM\ManyToOne(targetEntity: Membership::class, inversedBy: 'users')]
    private $membership;

    #[ORM\Column(type: 'date', nullable: true)]
    private $lastBooking;

    #[ORM\Column(type: 'date', nullable: true)]
    private $membershipExpiryDate;

    #[ORM\Column(type: 'smallint')]
    private $creditsRemaining;

    #[ORM\Column(type: 'boolean')]
    private $emailConsent;

    #[ORM\Column(type: 'boolean')]
    private $smsConsent;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getGender(): ?int
    {
        return $this->gender;
    }

    public function setGender(int $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getBirthdate(): ?\DateTimeInterface
    {
        return $this->birthdate;
    }

    public function setBirthdate(?\DateTimeInterface $birthdate): self
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(string $street): self
    {
        $this->street = $street;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(?string $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getZip(): ?string
    {
        return $this->zip;
    }

    public function setZip(?string $zip): self
    {
        $this->zip = $zip;

        return $this;
    }

    public function getTotalBookings(): ?int
    {
        return $this->totalBookings;
    }

    public function setTotalBookings(int $totalBookings): self
    {
        $this->totalBookings = $totalBookings;

        return $this;
    }

    public function getMembership(): ?Membership
    {
        return $this->membership;
    }

    public function setMembership(?Membership $membership): self
    {
        $this->membership = $membership;

        return $this;
    }

    public function getLastBooking(): ?\DateTimeInterface
    {
        return $this->lastBooking;
    }

    public function setLastBooking(?\DateTimeInterface $lastBooking): self
    {
        $this->lastBooking = $lastBooking;

        return $this;
    }

    public function getMembershipExpiryDate(): ?\DateTimeInterface
    {
        return $this->membershipExpiryDate;
    }

    public function setMembershipExpiryDate(?\DateTimeInterface $membershipExpiryDate): self
    {
        $this->membershipExpiryDate = $membershipExpiryDate;

        return $this;
    }

    public function getCreditsRemaining(): ?int
    {
        return $this->creditsRemaining;
    }

    public function setCreditsRemaining(int $creditsRemaining): self
    {
        $this->creditsRemaining = $creditsRemaining;

        return $this;
    }

    public function getEmailConsent(): ?bool
    {
        return $this->emailConsent;
    }

    public function setEmailConsent(bool $emailConsent): self
    {
        $this->emailConsent = $emailConsent;

        return $this;
    }

    public function getSmsConsent(): ?bool
    {
        return $this->smsConsent;
    }

    public function setSmsConsent(bool $smsConsent): self
    {
        $this->smsConsent = $smsConsent;

        return $this;
    }
}
