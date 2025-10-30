<?php

namespace App\Entity;

use App\Repository\ParsedDateRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ParsedDateRepository::class)]
class ParsedDate
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 10)]
    private ?string $day = null;

    #[ORM\Column]
    private ?int $month = null;

    #[ORM\Column]
    private ?int $year = null;

    #[ORM\Column(length: 10)]
    private ?string $dateString = null;

    #[ORM\Column]
    private ?int $century = null;

    #[ORM\Column]
    private ?int $count = null;

    #[ORM\Column(length: 10)]
    private ?string $monthName = null;

    #[ORM\Column(length: 10)]
    private ?string $dayOfWeek = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDay(): ?string
    {
        return $this->day;
    }

    public function setDay(string $day): static
    {
        $this->day = $day;

        return $this;
    }

    public function getMonth(): ?int
    {
        return $this->month;
    }

    public function setMonth(int $month): static
    {
        $this->month = $month;

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): static
    {
        $this->year = $year;

        return $this;
    }

    public function getDateString(): ?string
    {
        return $this->dateString;
    }

    public function setDateString(string $dateString): static
    {
        $this->dateString = $dateString;

        return $this;
    }

    public function getCentury(): ?int
    {
        return $this->century;
    }

    public function setCentury(int $century): static
    {
        $this->century = $century;

        return $this;
    }

    public function getCount(): ?int
    {
        return $this->count;
    }

    public function setCount(int $count): static
    {
        $this->count = $count;

        return $this;
    }

    public function getMonthName(): ?string
    {
        return $this->monthName;
    }

    public function setMonthName(string $monthName): static
    {
        $this->monthName = $monthName;

        return $this;
    }

    public function getDayOfWeek(): ?string
    {
        return $this->dayOfWeek;
    }

    public function setDayOfWeek(string $dayOfWeek): static
    {
        $this->dayOfWeek = $dayOfWeek;

        return $this;
    }
}
