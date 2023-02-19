<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $firstName = null;

    #[ORM\Column]
    private ?int $guestQuantity = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $allergyList = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['getReservations'])]
    private ?\DateTimeInterface $reservationDay = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(cascade: ['persist'], inversedBy: 'reservations')]
    private ?User $user = null;

    #[ORM\Column(length: 5)]
    #[Groups(['getReservations'])]
    private ?string $reservationTime = null;

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

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getGuestQuantity(): ?int
    {
        return $this->guestQuantity;
    }

    public function setGuestQuantity(int $guestQuantity): self
    {
        $this->guestQuantity = $guestQuantity;

        return $this;
    }

    public function getAllergyList(): ?string
    {
        return $this->allergyList;
    }

    public function setAllergyList(?string $allergyList): self
    {
        $this->allergyList = $allergyList;

        return $this;
    }

    public function getReservationDay(): ?\DateTimeInterface
    {
        return $this->reservationDay;
    }

    public function setReservationDay(\DateTimeInterface $reservationDay): self
    {
        $this->reservationDay = $reservationDay;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getReservationTime(): ?string
    {
        return $this->reservationTime;
    }

    public function setReservationTime(string $reservationTime): self
    {
        $this->reservationTime = $reservationTime;

        return $this;
    }
}
