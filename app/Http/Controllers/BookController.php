<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ApiResponser;     // Import ApiResponser trait
use App\Services\BookService;   // Import BookService class for handling book-related operations
use Firebase\JWT\JWT;           // Import JWT class for token handling

class BookController extends Controller
{
    use ApiResponser; // Use ApiResponser trait for standardized API responses

    protected $bookService; // Instance of BookService for interacting with book data

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService; // Inject BookService dependency via constructor
    }

    /**
     * Display a listing of books including recommendations and specific book by title.
     *
     * @param  Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Retrieve JWT token from Authorization header
        $token = $request->bearerToken();

        // Fetch book recommendations, book by title, and all books from BookService
        $bookRecommendations = $this->bookService->getBookRecommendations($token);
        $bookByTitle = $this->bookService->getBookByTitle($token, 'The Picture of Dorian Gray');
        $allBooks = $this->bookService->getAllBooks($token);

        // Return view with fetched data
        return view('books.index', compact('bookRecommendations', 'bookByTitle', 'allBooks'));
    }

    /**
     * Retrieve all books using BookService.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBooks(Request $request)
    {
        // Retrieve JWT token from Authorization header
        $token = $request->bearerToken();

        // Retrieve and return all books using BookService
        return $this->successResponse($this->bookService->obtainBooks($token));
    }
}
