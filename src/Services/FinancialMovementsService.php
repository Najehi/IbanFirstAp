<?php


namespace App\Services;


use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class FinancialMovementsService
{
    /**
     * @var HttpClientInterface
     */
    private $client;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var string
     */
    private $ibanFirstBaseUrl;

    /**
     * FinancialMovement constructor.
     * @param HttpClientInterface $client
     * @param LoggerInterface $logger
     * @param string $ibanFirstBaseUrl
     */
    public function __construct(HttpClientInterface $client, LoggerInterface $logger, string $ibanFirstBaseUrl)
    {
        $this->client = $client;
        $this->logger = $logger;
        $this->ibanFirstBaseUrl = $ibanFirstBaseUrl;
    }

    /**
     * @return \Symfony\Contracts\HttpClient\ResponseInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function getFinancialMovementsHistory()
    {
        return $this->call(Request::METHOD_GET, 'financialMovements/');
    }

    /**
     * @param $id
     * @return ResponseInterface
     * @throws TransportExceptionInterface
     */
    public function getFinancialMovementsDetails($id)
    {
        $path = str_replace(['{id}'], [$id], 'financialMovements/-' . $id);
        return $this->call(Request::METHOD_GET, $path);
    }

    /**
     * @param $method
     * @param $path
     * @param array $parameters
     * @return ResponseInterface
     * @throws TransportExceptionInterface
     * @throws \Exception
     */
    private function call($method, $path, $parameters = [])
    {
        $parameters = array_merge($parameters, ['headers' => ['X-WSSE' => $this->generateWsseToken()]]);
        try {
            $response = $this->client->request($method, $this->generateUrl($path), $parameters);

            $code = $response->getStatusCode();
            if ($code >= Response::HTTP_OK && $code < Response::HTTP_MULTIPLE_CHOICES) {
                return $response;
            }
            $this->logger->error("Error happen while calling $method $path with message with code error $code and content " . $response->getContent(false));
            throw new \Exception($code, 'Error');
        } catch (ResponseInterface | TransportExceptionInterface $exception) {
            throw $exception;
            $this->logger->error("Error happen while calling $method $path with message" . $exception->getMessage());
        }
    }

    /**
     * @param string $path
     * @return string
     */
    private function generateUrl(string $path)
    {
        return $this->ibanFirstBaseUrl . '/' . $path;
    }

    /**
     * @return string
     */
    private function generateWsseToken()
    {
        $username = "a00720d";
        $password = "6KPPczga4H6pR+ZeMj+iQ5UpB0foUoO3hQWOjUiYkESU3HGLfXwce8He7TfwY/k4c3hAcFViIFfKUC+GwcbYsQ==";
        $nonce = "";
        $nonce64 = "";
        $date = "";
        $digest = "";
        $header = "";
        // Making the nonce and the encoded nonce
        $chars = "0123456789abcdef";

        for ($i = 0; $i < 32; $i++) {
            $nonce .= $chars[rand(0, 15)];
        }
        $nonce64 = base64_encode($nonce);
        // Getting the date at the right format (e.g. YYYY-MM-DDTHH:MM:SSZ)
        $date = gmdate('c');
        $date = substr($date, 0, 19) . "Z";
        // Getting the password digest
        $digest = base64_encode(sha1($nonce . $date . $password, true));
        // Getting the X-WSSE header to put in your request
        $header = sprintf('UsernameToken Username="%s", PasswordDigest="%s", Nonce="%s", Created="%s"', $username, $digest, $nonce64, $date);
        return $header;
    }

}