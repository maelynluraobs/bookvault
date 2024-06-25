<?php

namespace App\Services;

use App\Traits\ConsumesExternalService; // Import trait for consuming external services
use GuzzleHttp\Client; // Import Guzzle HTTP client for making HTTP requests
use Illuminate\Support\Facades\Log; // Import Laravel Log facade for logging

class BookService
{
    use ConsumesExternalService; // Use the ConsumesExternalService trait

    protected $baseUri; // Base URI for the external service
    protected $client; // Guzzle HTTP client instance

    public function __construct(Client $client)
    {
        $this->client = $client; // Inject Guzzle HTTP client instance via dependency injection
        $this->baseUri = config('services.users1.base_uri'); // Set base URI from configuration
    }

    // Method to obtain all books
    public function obtainBooks($token)
    {
        return $this->performRequest('GET', '/api/books/getall-books', [], $this->getHeaders($token));
    }

    // Method to get book recommendations
    public function getBookRecommendations($token)
    {
        return $this->performRequest('GET', '/api/books/book-recommendations?genre=Fiction', [], $this->getHeaders($token));
    }

    // Method to get a book by title
    public function getBookByTitle($token, $title)
    {
        $endpoint = '/api/books/getbook?title=' . urlencode($title);
        return $this->performRequest('GET', $endpoint, [], $this->getHeaders($token));
    }

    // Alias method for obtaining all books (redundant, as obtainBooks() already exists)
    public function getAllBooks($token)
    {
        return $this->obtainBooks($token);
    }

    // Method to get HTTP headers including authorization and API keys
    private function getHeaders($token)
    {
        return [
            'Authorization' => 'Bearer ' . $token, // Authorization header with JWT token
            'X-RapidAPI-Host' => config('services.users1.host'), // RapidAPI host header
            'X-RapidAPI-Key' => config('services.users1.key'), // RapidAPI key header
        ];
    }

    // Method to perform an HTTP request using Guzzle client
    public function performRequest($method, $uri, $data = [], $headers = [])
    {
        try {
            // Make the HTTP request using Guzzle client
            $response = $this->client->request($method, $this->baseUri . $uri, [
                'headers' => $headers, // Set headers for the request
                'json' => $data, // Convert data to JSON format
            ]);

            // Return decoded JSON response body
            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            // Log any errors that occur during the request
            Log::error('Error during API request: ' . $e->getMessage());
            return null; // Return null in case of error
        }
    }
}
