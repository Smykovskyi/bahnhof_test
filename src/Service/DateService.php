<?php

namespace App\Service;

use App\Entity\ParsedDate;
use Doctrine\ORM\EntityManagerInterface;

class DateService
{
    private EntityManagerInterface $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @metjod validate
     * @param string $date
     * @return bool
     */
    public function validate(string $date): bool
    {
        if (empty($date)) {
            return false;
        }

        if(!is_string($date)) {
            return false;
        }

        // Checking date in "DD.MM.YYYY" format
        if(!preg_match('/^([0-3]\d)\.([0-1]\d)\.(\d{4})$/', $date)) {
            return false;
        }

        // Checking if year must be at least 1000 and at most 9999
        $year = date('Y', strtotime($date));
        if($year < 1000 or $year > 9999) {
            return false;
        }

        return true;
    }

    /**
     * @method dataExtraction
     * @param string $date
     * @return array
     */
    public function dataExtraction(string $date): array
    {
        $dataExtraction = [];
        $dataExtraction['dateString'] = $date;

        $dateObject = \DateTime::createFromFormat('d.m.Y', $date);

        $year = $dateObject->format('Y');
        $dataExtraction['year'] = $year;
        $dataExtraction['month'] = $dateObject->format('m');
        $dataExtraction['monthName'] = $dateObject->format('F');
        $dataExtraction['day'] = $dateObject->format('d');

        $dataExtraction['dayOfWeek'] = $dateObject->format('l');
        $dataExtraction['century'] = (int)floor(($year - 1) / 100) + 1;

        $this->persistDataExtraction($dataExtraction);
        return $dataExtraction;
    }


    private function persistDataExtraction($dataExtraction): void
    {
        $existing = $this->extractExistingData($dataExtraction['dateString']);

        if($existing) {
            $currentCount = $existing->getCount();
            $existing->setCount($currentCount + 1);

            $this->entityManager->flush();
        } else {
            $parsed = new ParsedDate();
            $parsed->setDateString($dataExtraction['dateString'])
                ->setYear($dataExtraction['year'])
                ->setMonth($dataExtraction['month'])
                ->setMonthName($dataExtraction['monthName'])
                ->setDay($dataExtraction['day'])
                ->setCentury($dataExtraction['century'])
                ->setDayOfWeek($dataExtraction['dayOfWeek'])
                ->setCount(1);

            $this->entityManager->persist($parsed);
            $this->entityManager->flush();
        }
    }


    private function extractExistingData(string $dateString): ?ParsedDate
    {
        return $this->entityManager->getRepository(ParsedDate::class)->findByDateString($dateString);
    }


    /**
     * @method getAllExistingData
     * @return array|null
     */
    public function getAllExistingData(): ?array
    {
        $items = $this->entityManager->getRepository(ParsedDate::class)->findAll();
        $result = [];

        foreach ($items as $item) {
            $result[$item->getDateString()] = [
                'id' => $item->getId(),
                'year' => $item->getYear(),
                'month' => $item->getMonth(),
                'monthName' => $item->getMonthName(),
                'day' => $item->getDay(),
                'dayOfWeek' => $item->getDayOfWeek(),
                'century' => $item->getCentury(),
                'count' => $item->getCount(),
            ];
        }

        return $result;
    }
}
