<?php


namespace App\Controller;


use App\Services\FinancialMovementsService;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Class FinancialMovementsController.
 */

class FinancialMovementsController extends AbstractController
{
    /**
     * @var FinancialMovementsService
     */
    private $financialMovementsService;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(FinancialMovementsService $financialMovementsService, LoggerInterface $logger)
    {
        $this->financialMovementsService = $financialMovementsService;
        $this->logger = $logger;
    }

    /**
     * @Route("/financialMovements/history" , name="get_financial_movements_history")
     * @param Request $request
     * @return JsonResponse
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function getFinancialMovementsHistory(Request $request)
    {
        $this->logger->info('Return the list of financial movements !');
        $getFinancialMovementsHistory = $this->financialMovementsService->getFinancialMovementsHistory();
        $serializer = new Serializer([new ObjectNormalizer()], [new JsonEncoder()]);
        $getFinancialMovementsHistoryResponse = $serializer->serialize($getFinancialMovementsHistory, 'json');
        return new JsonResponse($getFinancialMovementsHistoryResponse);
    }

    /**
     * @Route("/financialMovements/-{id}" , name="get_financial_movements_details")
     * @param Request $request
     * @return JsonResponse
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function getFinancialMovementsDetails(string $id)
    {
        $this->logger->info('Return the financial movements\'details !');
        $financialMovementsDetails = $this->financialMovementsService->getFinancialMovementsDetails($id);
        $serializer = new Serializer([new ObjectNormalizer()], [new JsonEncoder()]);
        $getFinancialMovementsDetails = $serializer->serialize($financialMovementsDetails, 'json');
        return new JsonResponse($getFinancialMovementsDetails);

    }
}