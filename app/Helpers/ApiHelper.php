<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


class ApiHelper
{
    public static function postTransaction($url, $postData, $headers = [], $parameters = [])
    {
        try {
            // Make the POST request using Laravel's HTTP Client
            $response = Http::withHeaders($headers)
                            ->post($url, $postData);

            // Check if the response is successful (status code 200-299)
            if ($response->successful()) {
                return $response;
            }

            // Handle non-successful responses here
            // Optionally, log or return the error message for debugging
            Log::error('POST request failed', [
                'url' => $url,
                'status' => $response->status(),
                'error' => $response->body(),
            ]);

            return null;
        } catch (\Exception $e) {
            // Handle exceptions such as connection issues
            Log::error('Exception occurred during POST request', [
                'url' => $url,
                'message' => $e->getMessage(),
            ]);

            return null;
        }
    }
}
