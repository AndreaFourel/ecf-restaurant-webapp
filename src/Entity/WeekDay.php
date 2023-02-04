<?php

namespace App\Entity;

use App\Repository\WeekDayRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WeekDayRepository::class)]
class WeekDay
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    private ?string $title = null;

    #[ORM\ManyToMany(targetEntity: DailySchedule::class, inversedBy: 'weekDays')]
    #[ORM\JoinTable(name: 'week_day_daily_schedule')]
    private Collection $dailySchedule;

    public function __construct()
    {
        $this->dailySchedule = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Collection<int, DailySchedule>
     */
    public function getDailySchedule(): Collection
    {
        return $this->dailySchedule;
    }

    public function addDailySchedule(DailySchedule $dailySchedule): self
    {
        if (!$this->dailySchedule->contains($dailySchedule)) {
            $this->dailySchedule->add($dailySchedule);
        }

        return $this;
    }

    public function removeDailySchedule(DailySchedule $dailySchedule): self
    {
        $this->dailySchedule->removeElement($dailySchedule);

        return $this;
    }

    public function __toString()
    {
        return $this->title;
    }
}
