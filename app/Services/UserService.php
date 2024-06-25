<?php

namespace App\Services;

use App\Traits\ConsumesExternalService; // Import trait for consuming external services

class UserService
{
    use ConsumesExternalService; // Use the ConsumesExternalService trait

    public $baseUri; // Base URI for the external service
    public $headers; // Headers for API requests

    public function __construct()
    {
        $this->baseUri = config('services.user.base_uri'); // Set base URI from configuration
        $this->headers = [
            'x-rapidapi-host' => config('services.user.host'), // Set host header from configuration
            'x-rapidapi-key' => config('services.user.key'), // Set API key header from configuration
        ];
    }

    // Method to obtain all users
    public function obtainUsers()
    {
        return $this->performRequest('GET', '/api/v1', [], $this->headers);
    }

    // Method to create a new user
    public function createUser($data)
    {
        return $this->performRequest('POST', '/api/v1', $data, array_merge($this->headers, ['Content-Type' => 'application/json']));
    }

    // Method to obtain a user by ID
    public function obtainUserById($id)
    {
        return $this->performRequest('GET', "/api/v1/{$id}", [], $this->headers);
    }

    // Method to update a user by ID
    public function updateUser($data, $id)
    {
        return $this->performRequest('PATCH', "/api/v1/{$id}", $data, array_merge($this->headers, ['Content-Type' => 'application/json']));
    }

    // Method to delete a user by ID
    public function deleteUser($id)
    {
        return $this->performRequest('DELETE', "/api/v1/{$id}", [], $this->headers);
    }
}
