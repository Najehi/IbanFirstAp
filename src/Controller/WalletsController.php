<?php


namespace App\Controller;

use App\Model\Wallet;
use App\Services\WalletService;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Class WalletsController
 * @package App\Controller
 */
class WalletsController extends  AbstractController
{

    /**
     * @var HttpClientInterface
     */
    private $client;
    /**
     * @var WalletService
     */
    private $walletService;
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(WalletService $walletService, LoggerInterface $logger, HttpClientInterface $client)
    {
        $this->client = $client;
        $this->walletService = $walletService;
        $this->logger = $logger;
    }

    /**
     * @Route("/wallets/list" , name="wallet_list")
     * @param Request $request
     * @return JsonResponse
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function getWalletList(Request $request)
    {
        $this->logger->info('Return the list of wallets !');
        $walletList = $this->walletService->getWalletList();
        $serializer = new Serializer([new ObjectNormalizer()], [new JsonEncoder()]);
        $walletBalanceSerializedResponse = $serializer->serialize($walletList, 'json');
        return new JsonResponse($walletBalanceSerializedResponse);
    }


    /**
     * @Route("/wallets/-{id}" , name="wallet_details")
     * @param Request $request
     * @param string $id
     * @return JsonResponse
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function getWalletDetails(Request $request, string $id)
    {
        $walletDetail = $this->walletService->getWalletDetails($id);
        $serializer = new Serializer([new ObjectNormalizer()], [new JsonEncoder()]);
        $walletDetails = $serializer->serialize($walletDetail, 'json');
        return new JsonResponse($walletDetails);
    }

    /**
     * @Route("/wallets/-{id}/balance/{date}" , name="wallet_balance")
     * @param Request $request
     * @param string $id
     * @param string $date
     * @return JsonResponse
     */
    public function getWalletBalanceForAGivenDate(Request $request, string $id, string $date)
    {
        $walletBalance = $this->walletService->getWalletBalanceForAGivenDate($id, $date);
        $serializer = new Serializer([new ObjectNormalizer()], [new JsonEncoder()]);
        $walletBalanceSerializedResponse = $serializer->serialize($walletBalance, 'json');
        return new JsonResponse($walletBalanceSerializedResponse);
    }


    /**
     * @Route("/wallets/create", name="post_wallet", methods={"POST"})
     * @param Request $request
     * @param ValidatorInterface $validator
     * @param SerializerInterface $serializer
     * @return
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function postWallet(Request $request, ValidatorInterface $validator, SerializerInterface $serializer)
    {
        $wallet = $serializer->deserialize($request->getContent(), Wallet::class, 'json');
        $errors = $validator->validate($wallet);

        if (!empty($errors)) {
            return $this->json([
                'code' => Response::HTTP_BAD_REQUEST,
                'errors' => $errors
            ]);
        }

        $response = $this->walletService->postWallet($wallet);

        return new $this->json($response);
    }

}