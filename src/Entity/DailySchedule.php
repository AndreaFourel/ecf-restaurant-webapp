<?php

namespace App\Entity;

use App\Repository\DailyScheduleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use function MongoDB\BSON\toJSON;

#[ORM\Entity(repositoryClass: DailyScheduleRepository::class)]
class DailySchedule
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    #[Groups(['getWeekDays'])]
    private ?\DateTimeInterface $openingTime = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    #[Groups(['getWeekDays'])]
    private ?\DateTimeInterface $closingTime = null;

    #[ORM\ManyToMany(targetEntity: WeekDay::class, mappedBy: 'dailySchedule')]
    private Collection $weekDays;

    public function __construct()
    {
        $this->weekDays = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOpeningTime(): ?\DateTimeInterface
    {
        return $this->openingTime;
    }

    public function setOpeningTime(\DateTimeInterface $openingTime): self
    {
        $this->openingTime = $openingTime;

        return $this;
    }

    public function getClosingTime(): ?\DateTimeInterface
    {
        return $this->closingTime;
    }

    public function setClosingTime(\DateTimeInterface $closingTime): self
    {
        $this->closingTime = $closingTime;

        return $this;
    }

    /**
     * @return Collection<int, WeekDay>
     */
    public function getWeekDays(): Collection
    {
        return $this->weekDays;
    }

    public function addWeekDay(WeekDay $weekDay): self
    {
        if (!$this->weekDays->contains($weekDay)) {
            $this->weekDays->add($weekDay);
            $weekDay->addDailySchedule($this);
        }

        return $this;
    }

    public function removeWeekDay(WeekDay $weekDay): self
    {
        if ($this->weekDays->removeElement($weekDay)) {
            $weekDay->removeDailySchedule($this);
        }

        return $this;
    }

    public function getDaysName(): array
    {
        $daysName = [];
        $weekDays = $this->getWeekDays();
        foreach ($weekDays as $day){
            $daysName[]= $day->getTitle();
        }
        return $daysName;
    }

}
