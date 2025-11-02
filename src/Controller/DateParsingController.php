<?php

namespace App\Controller;

use App\Service\DateService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class DateParsingController extends AbstractController
{
    private DateService $dateService;
    public function __construct(DateService $dateService) {
        $this->dateService = $dateService;
    }


    /**
     * @method parseDate
     * @param Request $request
     * @return JsonResponse
     */
    #[Route('/date/parsing', name: 'app_date_parsing', methods: ['POST'])]
    public function parseDate(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $dateString = $data['date'] ?? null;

        $result = $this->dateService->validate($dateString);

        if(!$result) {
            return $this->json(['error' => 'Missing or invalid date'], 400);
        }

        $dataExtraction = $this->dateService->dataExtraction($dateString);
        return $this->json($dataExtraction);
    }


    /**
     * @method viewDate
     * @return JsonResponse
     */
    #[Route('/date/view-dates', name: 'app_view_dates', methods: ['GET'])]
    public function viewDate(): JsonResponse
    {
        $result = $this->dateService->getAllExistingData();
        return $this->json($result);
    }
}
