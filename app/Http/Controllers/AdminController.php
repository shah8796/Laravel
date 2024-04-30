<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Import the User model
use App\Models\Book; // Import the User model
use App\Models\Favourite; // Import the User model
use Illuminate\Support\Facades\Auth; // Import the Auth facade

class AdminController extends Controller
{
    //
    public function index(){
        $users = User::all(); // Retrieve all users using the User model
        $books = Book::join('favourites', 'books.id', '=', 'favourites.bookId')->get();
        return view('admin', compact('users','books')); // Pass the users data to the view
    }
}
