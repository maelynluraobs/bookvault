<?php

namespace App\Services;

use GuzzleHttp\Client; // Import Guzzle HTTP client
use GuzzleHttp\Exception\ClientException; // Import Guzzle HTTP client exception

class BookshelfService
{
    protected $client; // Guzzle HTTP client instance
    protected $baseUrl; // Base URL for the Bookshelf API
    protected $apiKey; // API key for authentication

    public function __construct(Client $client)
    {
        $this->client = $client; // Inject Guzzle HTTP client instance via dependency injection
        $this->baseUrl = config('services.postman.base_url'); // Set base URL from configuration
        $this->apiKey = config('services.postman.api_key'); // Set API key from configuration
    }

    // Method to fetch all books with optional query parameters
    public function getAllBooks($query = [])
    {
        $response = $this->client->get($this->baseUrl . '/books', [
            'query' => $query // Pass query parameters in GET request
        ]);

        return json_decode($response->getBody(), true); // Decode JSON response
    }

    // Method to fetch a book by its ID
    public function getBookById($id)
    {
        try {
            $response = $this->client->get($this->baseUrl . "/books/{$id}");
            return json_decode($response->getBody(), true); // Decode JSON response
        } catch (ClientException $e) {
            if ($e->getResponse()->getStatusCode() == 404) {
                throw new \Exception("Book with id '{$id}' not found", 404); // Handle 404 error
            }
            throw $e; // Re-throw other exceptions
        }
    }

    // Method to add a new book
    public function addBook($data)
    {
        $response = $this->client->post($this->baseUrl . '/books', [
            'headers' => ['api-key' => $this->apiKey],                          // Set API key in headers
            'json' => $data                                                     // Send data as JSON in POST request
        ]);

        return json_decode($response->getBody(), true);                         // Decode JSON response
    }

    // Method to update an existing book
    public function updateBook($id, $data)
    {
        $response = $this->client->patch($this->baseUrl . "/books/{$id}", [
            'headers' => ['api-key' => $this->apiKey],                          // Set API key in headers
            'json' => $data                                                     // Send data as JSON in PATCH request
        ]);

        return json_decode($response->getBody(), true);                         // Decode JSON response
    }

    // Method to delete a book by its ID
    public function deleteBook($id)
    {
        try {
            $response = $this->client->delete($this->baseUrl . "/books/{$id}", [
                'headers' => ['api-key' => $this->apiKey]                        // Set API key in headers
            ]);

            return $response->getStatusCode() === 204;                          // Check if deletion was successful
        } catch (ClientException $e) {
            if ($e->getResponse()->getStatusCode() == 404) {
                throw new \Exception("Book with id '{$id}' deleted successfully.", 404); // Handle 404 error
            }
            throw $e;                                                                      // Re-throw other exceptions
        }
    }
}
