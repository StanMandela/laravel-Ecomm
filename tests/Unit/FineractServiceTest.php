<?php
// tests/Unit/FineractServiceTest.php

namespace Tests\Unit;

use App\Services\FineractService;
use Tests\TestCase;

class FineractServiceTest extends TestCase
{
    public function testCreateCodeValue()
    {
        // Create an instance of the service
        $service = new FineractService();

        // Define mock data to send
        $data = [
            'name' => 'Female',
            'description' => 'A person who identifies as being born a woman',
            'position' => 2,
            'isActive' => true,
        ];

        // Call the service method and assert the response
        $response = $service->createCodeValue(4, $data);

        $this->assertIsArray($response);
        // Further assertions based on the expected response
    }
}
