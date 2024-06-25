<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request; // Importing Request class from Illuminate\Http for handling HTTP requests
use App\Traits\ApiResponser; // Importing ApiResponser trait for standard API responses
use App\Services\UserService; // Importing UserService for handling user-related operations


class UserController extends Controller
{
    use ApiResponser;                   // Import ApiResponser trait for standardized API responses

    protected $userService;             // Instance of UserService for interacting with user-related data

    public function __construct(UserService $userService)
    {
        $this->userService = $userService; // Inject UserService dependency via constructor
    }

    /**
     * Retrieve all users.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $users = $this->userService->obtainUsers();                           // Fetch all users using obtainUsers() method from UserService
        return $this->successResponse($users);                                // Return users as a successful JSON response using successResponse() method
    }

    /**
     * Alias for index method to retrieve all users.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllItems()
    {
        $items = $this->userService->obtainUsers();                          // Fetch all users (same as index method)
        return $this->successResponse($items);                               // Return users as a successful JSON response
    }

    /**
     * Create a new user.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createUser(Request $request)
    {
        $createdUser = $this->userService->createUser($request->all());                 // Create a new user using createUser() method from UserService
        return $this->successResponse($createdUser, 'User created successfully', 201); // Return created user with success message and HTTP status code 201 (Created)
    }

    /**
     * Retrieve a user by ID.
     *
     * @param  mixed  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserById($id)
    {
        try {
            $user = $this->userService->obtainUserById($id); // Attempt to fetch user by ID using obtainUserById() method from UserService
            return $this->successResponse($user, 'User details retrieved successfully'); // Return user details with success message
        } catch (\Exception $e) {
            if ($e->getCode() == 404) {
                return $this->errorResponse('User not found', 404); // Handle 404 Not Found error with appropriate error message and status code
            }
            return $this->errorResponse('An error occurred', 500); // Handle other errors with generic error message and status code
        }
    }

    /**
     * Update a user by ID.
     *
     * @param  Request  $request
     * @param  mixed  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateUser(Request $request, $id)
    {
        $updatedUser = $this->userService->updateUser($request->all(), $id); // Update user by ID using updateUser() method from UserService
        return $this->successResponse($updatedUser, 'User updated successfully'); // Return updated user with success message
    }

    /**
     * Delete a user by ID.
     *
     * @param  mixed  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteUser($id)
    {
        try {
            $this->userService->deleteUser($id); // Attempt to delete user by ID using deleteUser() method from UserService
            return $this->successResponse(null, 'User deleted successfully', 204); // Return success message with HTTP status code 204 (No Content)
        } catch (\Exception $e) {
            if ($e->getCode() == 404) {
                return $this->errorResponse('User not found', 404); // Handle 404 Not Found error with appropriate error message and status code
            }
            return $this->errorResponse('An error occurred', 500); // Handle other errors with generic error message and status code
        }
    }
}
