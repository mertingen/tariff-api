<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TariffControllerTest extends WebTestCase
{
    public function testCompareAction()
    {
        // Create a client to simulate requests to your application
        $client = static::createClient();

        // Make a GET request to '/tariffs' endpoint with query parameter 'consumption' set to 2000
        $client->request('GET', '/tariffs', ['consumption' => 2000]);

        // Assert that the HTTP status code of the response is 200 (OK)
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        // Decode the JSON response content into an associative array
        $responseData = json_decode($client->getResponse()->getContent(), true);

        // Assert that the 'status' key exists in the response data and its value is true
        $this->assertArrayHasKey('status', $responseData);
        $this->assertTrue($responseData['status']);

        // Assert that the 'data' key exists in the response data and it is not empty
        $this->assertArrayHasKey('data', $responseData);
        $this->assertNotEmpty($responseData['data']);
    }
}
