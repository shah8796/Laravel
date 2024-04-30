<?php

namespace App\Livewire;
use Intervention\Image\Facades\Image as Image;
use Livewire\Component;
use App\Models\User;
use App\Models\Book;
use App\Models\Favourite;
use App\Livewire\Rules\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rules;
use Livewire\WithFileUploads;

class Administrator extends Component
{
    use WithFileUploads;
    public $users;
    public $selectedUserId;
    public $user;
    public $books;
    public $fav;
    public $bookviewer = false;
    public $edituser = false;
    public $addUser=false;
    public $editBook = false;
    public $addBook = false;
    public $editUserId;
    public $editUserName;
    public $editUserEmail;
    public $editUserPassword;
    public $newUserName;
    public $newUserEmail;
    public $newUserPassword;
    public $newUserIsAdmin;
    public $book;
    public $editbookshortdescription;
    public $editbooktitle;
    public $editbookdetail;
    public $editbookId;
    public $newbookshortdescription;
    public $newbooktitle;
    public $newbookdetail;
    public $photos;

    






    public function mount()
    {
        $this->users = User::all();
        $this->book=Book::all();
        
    }

    public function viewUser($userId)
    {
        $this->selectedUserId = $userId;
        $this->bookviewer = true;
        // Retrieve books for the selected user
        $this->books = Book::join('favourites', 'books.id', '=', 'favourites.bookId')
                           ->where('favourites.userId', $userId)
                           ->get();
        $this->fav=Favourite::all();   
        $this->addUser=true;           
    }
    public function showbooks()
    {
        // $this->selectedUserId = $userId;
        $this->bookviewer = true;
        // Retrieve books for the selected user
        $this->books = Book::all();
        $this->fav=Favourite::all();   
        $this->addUser=false;           
    }

    public function showAddUserForm()
    {
        $this->addUser=true;
        
        $this->newUserName = '';
        $this->newUserEmail = '';
        $this->newUserPassword = '';


    }

    public function addedUser()
    {
        $this->validate([
            'newUserName' => ['required', 'string', 'max:255'],
            'newUserEmail' => ['required', 'string', 'lowercase', 'email', 'max:255'],
            'newUserPassword' => ['required'],
        ]);
    
        $user = User::create([
            'name' => $this->newUserName,
            'email' => $this->newUserEmail,
            'password' => Hash::make($this->newUserPassword),
            'is_admin' => $this->newUserIsAdmin,
        ]);
        ini_set('max_execution_time', 180);
    
        $this->users = User::all();
        $this->newUserName = '';
        $this->newUserEmail = '';
        $this->newUserPassword = '';
        $this->newUserIsAdmin ='';
        $this->addUser=false;
        $this->edituser = false;
    
        // Implement logic to add a new user
        // Implement logic to add a new user
    }

    public function editUser($userId)
    {
        $this->bookviewer = false;
        
        
        $user = User::find($userId);
        $this->editUserId = $userId;
        $this->editUserName = $user->name;
        $this->editUserEmail = $user->email;
        $this->editUserPassword = $user->password;
        $this->edituser = true;
        $this->addUser=false;

        // Implement logic to edit user with ID $userId
    }
    public function editbook($bookId)
    {
        $this->bookviewer = false;
        $this->editBook = true;
        $books = Book::find($bookId);
        $this->editbookId = $bookId;
        $this->editbookshortdescription=$books->short_description;
        $this->editbooktitle=$books->title;
        $this->editbookdetail=$books->details;
        $this->edituser = false;
        $this->addUser=false;

        // Implement logic to edit user with ID $userId
    }
    public function addbooks()
    {
        $this->bookviewer = false;
        $this->editBook = false;
        $this->newbookId = '';
        $this->newbookshortdescription='';
        $this->newbooktitle='';
        $this->newbookdetail='';
        $this->photos='';
        $this->addBook = true;
        $this->edituser = false;
        $this->addUser=false;

        // Implement logic to edit user with ID $userId
    }

    public function editedbook()
    {
        
        $book = Book::find($this->editbookId);
        $book->update([
            'title' => $this->editbooktitle,
            'short_description' =>  $this->editbookshortdescription,
            'details' => $this->editbookdetail,
        ]);
        // $books = Book::find($bookId);
        $this->edituser = false;
        $this->addUser=false;
        $this->editBook = false;
    }
    public function addedbook()
{
    $this->validate([
        'photos' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust max file size as needed
        'newbooktitle' => 'required|string|max:255',
        'newbookshortdescription' => 'required|string',
        'newbookdetail' => 'required|string',
    ]);

    if ($this->photos) {
        $image = $this->photos;
        $filename = time() . '.' . $image->getClientOriginalExtension();
        // Store the image in the storage directory
        $image->storePubliclyAs('images', $filename, 'public');
    }

    Book::create([
        'image' => $filename ?? null, // Ensure to handle case when $filename is not set
        'title' => $this->newbooktitle,
        'short_description' => $this->newbookshortdescription,
        'details' => $this->newbookdetail,
    ]);

    // Reset form fields and set appropriate flags
    $this->reset(['newbooktitle', 'newbookshortdescription', 'newbookdetail', 'photos']);
    $this->addBook = false;
    $this->edituser = false;
    $this->addUser = false;
    $this->editBook = false;

    // Provide feedback to the user (optional)
    session()->flash('message', 'Book added successfully!');
}

    public function editedUser()
    {
        $this->validate([
            'editUserName' => ['required', 'string', 'max:255'],
            'editUserEmail' => ['required', 'string', 'lowercase', 'email', 'max:255'],
            'editUserPassword' => ['required'],
        ]);
        
        $user = User::find($this->editUserId);
        
        $user->update([
            'name' => $this->editUserName,
            'email' => $this->editUserEmail,
            'password' => Hash::make($this->editUserPassword),
        ]);
        $this->users = User::all();
        $this->edituser = false;
        $this->addUser=false;
    }

    public function deleteUser($userId)
    {
        // Implement logic to delete user with ID $userId
        User::where('id', $userId)->delete();
        Favourite::where('userId',$userId)->delete();
        $this->users = User::all();
        $this->bookviewer = false;


    }
    public function deleteBook($bookId)
    {
        // Implement logic to delete user with ID $userId
        Book::where('id', $bookId)->delete();
        Favourite::where('bookId',$bookId)->delete();
        $this->users = User::all();
        $this->bookviewer = false;

    }

    public function render()
    {
        return view('livewire.administrator');
    }
}
