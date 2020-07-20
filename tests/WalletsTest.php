<?php


namespace App\Tests;


use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class WalletsTest
 * @package App\Tests
 */
class WalletsTest extends WebTestCase
{

    public function setUp(): void
    {
        parent::setup();
    }

    public function testGetWalletList()
    {
            $client = static::createClient();
            $client->request('GET', '/wallets/list');
            $response = $client->getResponse();
            $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
            $this->assertJson($response->getContent());
           self::assertSame(Response::HTTP_OK, $response->getStatusCode());

    }

    public function testGetWalletDetails()
    {
        $id = 'NDgyODM';
        $client = static::createClient();
        $client->request('GET', '/wallets/-'.$id);
        $response = $client->getResponse();
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
        $this->assertJson($response->getContent());
        self::assertSame(Response::HTTP_OK, $response->getStatusCode());

    }

    public function testGetWalletBalanceForAGivenDate()
    {
        $id = 'NDgyODM';
        $date = '2020-04-02';
        $client = static::createClient();
        $client->request('GET', '/wallets/-'.$id.'/balance/'.$date);
        $response = $client->getResponse();
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
        $this->assertJson($response->getContent());
        self::assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());

    }

}