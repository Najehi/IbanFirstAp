<?php


namespace App\Tests;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class FinancialMovementsTest
 * @package App\Tests
 */
class FinancialMovementsTest extends WebTestCase
{

    public function testGetFinancialMovementsHistory()
    {

        $client = static::createClient();
        $client->request('GET', '/financialMovements/history');
        $response = $client->getResponse();
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'), $response->headers);
        $this->assertJson($response->getContent());
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode(), $response->getContent());


    }

    public function testGetFinancialMovementsDetails()
    {
        $id = "MTA4NDAyOQ";
        $client = static::createClient();
        $client->request('GET', 'financialMovements/-' . $id);
        $response = $client->getResponse();
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
        $this->assertJson($response->getContent());
        self::assertSame(Response::HTTP_OK, $response->getStatusCode());

    }

}