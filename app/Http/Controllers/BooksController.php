<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Favourite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class BooksController extends Controller
{
    //
    public function index()
    {
        $books = Book::all();
        
        return view('welcome', ['books' => $books]);
    }
    public function Adminindex(Request $request)
    {
        $userid=$request->userid;
        $books =Book::join('favourites', 'books.id', '=', 'favourites.bookId')
        ->where('favourites.userId', $userid)
        ->get();
        return view('books', ['books' => $books]);
    }

    public function favourites(Request $request)
    {
        $bookId = $request->bookid;
        

        $userId = Auth::id(); // Corrected usage of Auth::id()
        // $isfav=$request->isFavourite;
        $isFavorited = Favourite::where('bookId', $bookId)
                                ->where('userId', $userId)
                                ->exists();

        if ($isFavorited) {
            // Book is already favorited, so unfavorite it
            Favourite::where('bookId', $bookId)
                     ->where('userId', $userId)
                     ->truncate();

            return response()->json(['message' => 'Book unfavorited successfully']);
        } else {
            // Book is not favorited, so favorite it
            Favourite::create([
                'bookId' => $bookId,
                'userId' => $userId
            ]);

            return response()->json(['message' => 'Book favorited successfully']);
        }

   



    }
    public function favouriteDisplay(Request $request)
    {
        $fav=Favourite::all();
        $userid = Auth::id();
        $books = Book::join('favourites', 'books.id', '=', 'favourites.bookId')
                    ->where('favourites.userId', $userid)
                    ->get();

        $html = '';
        foreach ($books as $book) {
            // $isFavorite = in_array($book->id, $fav); // Assuming $fav is predefined somewhere

            $html .= '<div id="books" class="max-w-md bg-white p-5 shadow-lg rounded-lg overflow-hidden">';
            $html .= '<img class="w-full h-56 object-fill object-center" src="' . asset('images/' . $book->image) . '" alt="Image">';
            $html .= '<div class="p-4">';
            $html .= '<h2 class="text-xl font-semibold text-gray-800">' . $book->title . '</h2>';
            $html .= '<p class="mt-2 text-gray-600">' . $book->short_description . '</p>';
            $html .= '<p class="mt-2 text-gray-600">' . $book->price . '</p>';
            $html .= '<div class="mt-4">';
            $html .= '<a href="#" id="' . $book->id . '" class="readmore text-blue-500 inline-block">Read more</a>';

            // if ($isFavorite) {
                $html .= '<span id="' . $book->id . '" class="favorited favorite-star text-yellow-500 cursor-pointer ml-2">&#9733;</span>';
            // } else {
            //     $html .= '<span id="' . $book->id . '" class="favorite-star text-yellow-500 cursor-pointer ml-2">&#9734;</span>';
            // }

            $html .= '</div>';
            $html .= '<div id="details_' . $book->id . '" class="details hidden mt-4">';
            $html .= '<p class="mt-2 text-gray-600">' . $book->details . '</p>';
            $html .= '</div>';
            $html .= '</div>';
            $html .= '</div>';
        }

        return $html;
    }
    public function searchview(Request $request)
    {
        $fav=Favourite::all();
        $userid = Auth::id();
        Log::info('data: ' . $request->search);
        $value=$request->search;
        
        $books = Book::where('title', 'LIKE', '%' . $value . '%')->orWhere('short_description', 'LIKE', '%' . $value . '%')->get();


        $html = '';
        foreach ($books as $book) {
            // $isFavorite = in_array($book->id, $fav); // Assuming $fav is predefined somewhere

            $html .= '<div id="books" class="max-w-md bg-white p-5 shadow-lg rounded-lg overflow-hidden">';
            $html .= '<img class="w-full h-56 object-fill object-center" src="' . asset('images/' . $book->image) . '" alt="Image">';
            $html .= '<div class="p-4">';
            $html .= '<h2 class="text-xl font-semibold text-gray-800">' . $book->title . '</h2>';
            $html .= '<p class="mt-2 text-gray-600">' . $book->short_description . '</p>';
            $html .= '<p class="mt-2 text-gray-600">' . $book->price . '</p>';
            $html .= '<div class="mt-4">';
            $html .= '<a href="#" id="' . $book->id . '" class="readmore text-blue-500 inline-block">Read more</a>';

            // if ($isFavorite) {
                $html .= '<span id="' . $book->id . '" class="favorited favorite-star text-yellow-500 cursor-pointer ml-2">&#9733;</span>';
            // } else {
            //     $html .= '<span id="' . $book->id . '" class="favorite-star text-yellow-500 cursor-pointer ml-2">&#9734;</span>';
            // }

            $html .= '</div>';
            $html .= '<div id="details_' . $book->id . '" class="details hidden mt-4">';
            $html .= '<p class="mt-2 text-gray-600">' . $book->details . '</p>';
            $html .= '</div>';
            $html .= '</div>';
            $html .= '</div>';
        }

        return $html;
    }
    public function allDisplay(Request $request)
    {
        
        $userid = Auth::id();
        $fav = Favourite::where('userId', $userid)->get();
        $books = Book::all();

        $html = '';
        foreach ($books as $book) {
            $isFavorite = $fav->contains('bookId', $book->id); // Assuming $fav is predefined somewhere

            $html .= '<div id="books" class="max-w-md bg-white p-5 shadow-lg rounded-lg overflow-hidden">';
            $html .= '<img class="w-full h-56 object-fill object-center" src="' . asset('images/' . $book->image) . '" alt="Image">';
            $html .= '<div class="p-4">';
            $html .= '<h2 class="text-xl font-semibold text-gray-800">' . $book->title . '</h2>';
            $html .= '<p class="mt-2 text-gray-600">' . $book->short_description . '</p>';
            $html .= '<p class="mt-2 text-gray-600">' . $book->price . '</p>';
            $html .= '<div class="mt-4">';
            $html .= '<a href="#" id="' . $book->id . '" class="readmore text-blue-500 inline-block">Read more</a>';

             if ($isFavorite) {
                $html .= '<span id="' . $book->id . '" class="favorited favorite-star text-yellow-500 cursor-pointer ml-2">&#9733;</span>';
             } else {
                 $html .= '<span id="' . $book->id . '" class="favorite-star text-yellow-500 cursor-pointer ml-2">&#9734;</span>';
             }

            $html .= '</div>';
            $html .= '<div id="details_' . $book->id . '" class="details hidden mt-4">';
            $html .= '<p class="mt-2 text-gray-600">' . $book->details . '</p>';
            $html .= '</div>';
            $html .= '</div>';
            $html .= '</div>';
        }

        return $html;
    }



}
