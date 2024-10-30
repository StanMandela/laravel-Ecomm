<?php

// app/Services/FineractService.php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class FineractService
{
    protected $baseUrl;
    protected $accessToken;


    public function __construct()
    {
        // Set the base URL for Fineract API
        $this->baseUrl = env('FINERACT_BASE_URL', 'http://localhost:8080/fineract-provider/api/v1');
        $this->accessToken = $this->getAccessToken(); // Fetch the token during service initialization

    }

    public function createCodeValue($codeId, array $data)
    {
        $url = "{$this->baseUrl}/codes/{$codeId}/codevalues?tenantIdentifier=default";

        // Make a POST request to Fineract API using Laravel's Http facade
        $response = Http::withHeaders([
           'Authorization' => 'Basic ' . $this->accessToken,
           'Content-Type' => 'application/json',
        ])->post($url, $data);

         // Handle errors or return response as needed
         if ($response->failed()) {
            return [
                'status' => $response->status(),
                'error' => $response->json() ?? 'Unknown error'
            ];
        }

        return $response->json();
    }

    // Make General PUT,POST 
    public function makeRequest($method, $urlPath, array $data = [])
{
    $url = "{$this->baseUrl}/{$urlPath}?tenantIdentifier=default";

    // Make a request to Fineract API using Laravel's Http facade
    $response = Http::withHeaders([
        'Authorization' => 'Basic ' . $this->accessToken, // Use Basic Auth or modify based on your requirements
        'Content-Type' => 'application/json',
    ])->$method($url, $data);

    // Handle errors or return response as needed
    if ($response->failed()) {
        return [
            'status' => $response->status(),
            'error' => $response->json()['error'] ?? 'Unknown error'
        ];
    }

    return $response->json();
}



    public function getCodeValues()
{
    $url = "{$this->baseUrl}/codes?tenantIdentifier=default";

    // Make a GET request to Fineract API using Laravel's Http facade
    $response = Http::withHeaders([
        'Authorization' => 'Basic ' . $this->accessToken,
        'Content-Type' => 'application/json',
    ])->get($url);

    // // Handle errors or return response as needed
    // if ($response->failed()) {
    //     return [
    //         'status' => $response->status(),
    //         'error' => $response->json()['error'] ?? 'Unknown error'
    //     ];
    // }

    return $response->json();
}


    protected function getAccessToken()
    {
        // Logic to obtain or refresh the access token
        return 'bWlmb3M6cGFzc3dvcmQ=';
    }
}
