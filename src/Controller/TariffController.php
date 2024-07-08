<?php

namespace App\Controller;

use App\Mock\TariffMock;
use App\Service\TariffService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TariffController extends AbstractController
{
    #[Route('/tariffs', name: 'tariffs', methods: ['GET'])]
    public function compare(Request $request, TariffService $tariffService, TariffMock $tariffMock): JsonResponse
    {
        // Retrieve 'consumption' query parameter from the request
        $consumption = $request->query->get('consumption');

        // Validate if 'consumption' is numeric
        if (!is_numeric($consumption)) {
            return $this->json(
                [
                    'success' => false,
                    'message' => 'Invalid consumption value',
                    'data' => [],
                ],
                400
            );
        }

        try {
            // Calculate annual costs for tariffs based on consumption
            $results = array_map(function ($tariff) use ($consumption, $tariffService) {
                return [
                    'name' => $tariff->name,
                    'annualCost' => $tariffService->calculateAnnualCost($tariff, $consumption)
                ];
            }, $tariffMock->getTariffs());

            // Sort results by 'annualCost' in ascending order
            usort($results, function ($a, $b) {
                return $a['annualCost'] <=> $b['annualCost'];
            });

            // Return JSON response with sorted tariff data
            return $this->json(
                [
                    'status' => true,
                    'message' => '',
                    'data' => $results,
                ]
            );
        } catch (Exception $e) {
            // Handle exceptions and return JSON response with error message
            return $this->json(
                [
                    'status' => false,
                    'message' => $e->getMessage(),
                    'data' => []
                ],
                500
            );
        }
    }
}
