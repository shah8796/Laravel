<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BooksController;
use Illuminate\Support\Facades\Route;
use App\Models\Book;
use App\Models\Favourite;
use App\Http\Livewire\AdminComponent;
use App\Http\Controllers\AdminController;


// Route::get('/', function () {
//     return view('welcome');
// });
// use App\Http\Livewire\AdminComponent;

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', function () {
        return view('livewire.admin-component');
    })->name('manage.users');
    // Route::get('/index', [AdminController::class, 'index'])->name('admin');
    Route::get('/books', [BooksController::class, 'Adminindex'])->name('/books');
});
Route::get('/index', [AdminController::class, 'index'])->name('admin');

Route::get('/', [BooksController::class, 'index'])->name('welcome');

Route::get('/dashboard', function () {
    $books = Book::all();
    $userid=Auth::id();
    $fav=Favourite::where('userId',$userid)->get();
    return view('dashboard', compact('books','fav'));
})->middleware(['auth', 'verified'])->name('dashboard');
Route::post('/favourite', [BooksController::class, 'favourites'])->name('favourite');
Route::post('/search', [BooksController::class, 'searchview'])->name('searchview');
Route::post('/favouriteview', [BooksController::class, 'favouriteDisplay'])->name('favouriteview');
Route::post('/allview', [BooksController::class, 'allDisplay'])->name('allview');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Route::post('/favourite',[BooksController::class,'favourites'])->name('favourite');
});

require __DIR__.'/auth.php';
