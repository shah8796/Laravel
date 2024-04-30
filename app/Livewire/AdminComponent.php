<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Favourite;
use App\Models\Book;


class AdminComponent extends Component
{
    public $users;
    public $selectedUserId;
    public $books;


    public function mount()
    {
        $this->users = User::all();
    }

    public function viewUser($userId)
    {
        $selectedUserId=$userId;
        $books = Book::join('favourites', 'books.id', '=', 'favourites.bookId')->where('favourites.userId',$userid)->get();
       

        // Implement logic to view user with ID $userId
    }

    public function addUser()
    {
        // Implement logic to add a new user
    }

    public function editUser($userId)
    {
        // Implement logic to edit user with ID $userId
    }

    public function deleteUser($userId)
    {
        // Implement logic to delete user with ID $userId
    }

    public function render()
    {
        return view('livewire.admin-component');
    }
}
