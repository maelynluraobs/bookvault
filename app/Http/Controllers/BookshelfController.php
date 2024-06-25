<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;        // Importing Request class from Illuminate\Http for handling HTTP requests
use App\Services\BookshelfService; // Importing BookshelfService for handling book-related operations
use Illuminate\Http\JsonResponse; // Importing JsonResponse class from Illuminate\Http for JSON responses

class BookshelfController extends Controller
{
    protected $bookshelfService; // Instance of BookshelfService for interacting with bookshelf data

    public function __construct(BookshelfService $bookshelfService)
    {
        $this->bookshelfService = $bookshelfService; // Inject BookshelfService dependency via constructor
    }

    /**
     * Retrieve all books from the bookshelf.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $books = $this->bookshelfService->getAllBooks($request->query()); // Fetch all books with optional query parameters
        return response()->json($books); // Return books as JSON response
    }

    /**
     * Retrieve a specific book by ID.
     *
     * @param  mixed  $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        try {
            $book = $this->bookshelfService->getBookById($id); // Attempt to fetch book by ID
            return response()->json($book); // Return book details as JSON response
        } catch (\Exception $e) {
            if ($e->getCode() == 404) {
                return response()->json(['message' => $e->getMessage()], 404); // Handle 404 Not Found error
            }
            return response()->json(['message' => 'An error occurred'], 500); // Handle other errors
        }
    }

    /**
     * Store a new book.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $book = $this->bookshelfService->addBook($request->all()); // Add a new book based on request data
        return response()->json($book, 201); // Return newly created book and HTTP status code 201 (Created)
    }

    /**
     * Update an existing book by ID.
     *
     * @param  Request  $request
     * @param  mixed  $id
     * @return JsonResponse
     */
    public function update(Request $request, $id): JsonResponse
    {
        $book = $this->bookshelfService->updateBook($id, $request->all()); // Update existing book by ID with new data
        return response()->json($book); // Return updated book details as JSON response
    }

    /**
     * Delete a book by ID.
     *
     * @param  mixed  $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        try {
            $this->bookshelfService->deleteBook($id); // Attempt to delete book by ID
            return response()->json(['message' => 'Successfully deleted'], 204); // Return success message with HTTP status code 204 (No Content)
        } catch (\Exception $e) {
            if ($e->getCode() == 404) {
                return response()->json(['message' => $e->getMessage()], 404); // Handle 404 Not Found error
            }
            return response()->json(['message' => 'An error occurred'], 500); // Handle other errors
        }
    }
}
