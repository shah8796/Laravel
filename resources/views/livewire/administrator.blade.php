<div class="container mx-auto ">
    <h2 class="font-semibold text-xl text-white bg-gray-800 leading-tight px-4 py-6">
        {{ __('Admin') }}
    </h2>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-between mt-4 px-4">
            <button wire:click="showAddUserForm" class="bg-blue-200 rounded-md p-3">Add</button>
            <button wire:click="showbooks" class="bg-blue-200 rounded-md p-3 ml-2">Book</button>
        </div>

        @foreach ($users as $user)
        <div id="{{ $user->id }}" class="flex justify-between items-center p-5 border-b border-gray-300">
            <span>{{ $user->name }}</span>
            <div class="bg-gray-200 rounded-md">
                <button wire:click="viewUser({{ $user->id }})" class="bg-blue-200 rounded-md p-3 ml-2">View</button>
                <button wire:click="editUser({{ $user->id }})" class="bg-blue-200 rounded-md p-3 ml-2">Edit</button>
                <button wire:click="deleteUser({{ $user->id }})" class="bg-blue-200 rounded-md p-3 ml-2">Delete</button>
            </div>
        </div>
        @endforeach

        @if($bookviewer)
        <button wire:click="addbooks" class="bg-blue-200 rounded-md p-3 mt-4">Add Book</button>
        <div id="bookview" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach ($books as $book)
            <div id="books" class="max-w-md bg-white shadow-lg rounded-lg overflow-hidden">
                <button wire:click="editbook({{$book->id}})" class="bg-blue-200 rounded-md p-3 ml-2">Edit</button>
                <button wire:click="deleteBook({{$book->id}})" class="bg-blue-200 rounded-md p-3 ml-2">Delete</button>
                <img class="w-full h-56 object-cover" src="{{ asset('images/' . $book->image) }}" alt="Image">
                <div class="p-4">
                    <h2 class="text-xl font-semibold text-gray-800">{{ $book->title }}</h2>
                    <p class="mt-2 text-gray-600">{{ $book->short_description }}</p>
                    <p class="mt-2 text-gray-600">{{ $book->price }}</p>
                    <div class="mt-4">
                        @auth
                        <a href="#" id="{{$book->id}}" class="readmore text-blue-500 inline-block">Read more</a>
                        @php
                        $isFavorite = $fav->contains('bookId', $book->id);
                        @endphp
                        @if($isFavorite)
                        <span id="{{$book->id}}" class="favorite-star text-yellow-500 cursor-pointer ml-2">&#9733;</span>
                        @else
                        <span id="{{$book->id}}" class="favorite-star text-yellow-500 cursor-pointer ml-2">&#9734;</span>
                        @endif
                        @else
                        <span class="text-gray-500 inline-block">Please log in to read more</span>
                        @endauth
                    </div>
                    <div id="details_{{ $book->id }}" class="details hidden mt-4">
                        <p class="mt-2 text-gray-600">{{ $book->details }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif

        @if($edituser)
        
        <form class="max-w-sm mx-auto mt-4" wire:submit.prevent="editedUser">
            <form class="max-w-sm mx-auto" wire:submit.prevent="editedUser">
                <div class="mb-5">
                    <label for="editUserName" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Book title</label>
                    <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" type="text" wire:model="editUserName" placeholder="Name" required>
                <div class="mb-5">
                    <label for="editUserEmail" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Book title</label>
                    <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" type="email" wire:model="editUserEmail" placeholder="Email" required>
                <div class="mb-5">
                    <label for="editUserPassword" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Book title</label>
                    <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" type="password" wire:model="editUserPassword" placeholder="Password" required>
                <div class="mb-5">
                    <button type="submit">Update</button>
                </div>
            </form>
        </form>
        @endif

        @if($addUser)
        <!-- Add User Form -->
        <form class="max-w-sm mx-auto" wire:submit.prevent="addedUser">
            <div class="mb-5">
                <label for="newUserName" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Book title</label>
                <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" type="text" wire:model="newUserName" placeholder="Name" required>
            </div>
            <div class="mb-5">
                <label for="newUserEmail" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Book title</label>
                <input type="email" wire:model="newUserEmail" placeholder="Email" required>
            </div>
            <div class="mb-5">
                <label for="newUserPassword" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Book title</label>
                <input type="password" wire:model="newUserPassword" placeholder="Password" required>
            </div>
            <div class="mb-5">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="is_admin">Is Admin:</label>
                <input type="checkbox" wire:model="newUserIsAdmin" id="is_admin">
            </div>
            <div class="mb-5">
                <button type="submit">Add User</button>
            </div>
        </form>
            <!-- Input fields for adding new user -->
        
        @endif

        @if($editBook)
        <!-- Edit Book Form -->
        <form class="max-w-sm mx-auto" wire:submit.prevent="editedbook">
            <div class="mb-5">
                <label for="editbooktitle" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Book title</label>
                <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" type="text" wire:model="editbooktitle" placeholder="title" required>
            </div>
            <div class="mb-5">
                <label for="editbookshortdescription" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">short_description</label>
                <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" type="text" wire:model="editbookshortdescription" placeholder="short_description" required>
            </div>
            <div class="mb-5">
                <label for="editbookdetail" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Book title</label>
                <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" type="text" wire:model="editbookdetail" placeholder="details" required>
            </div>
            <div class="mb-5">
                <button type="submit">Add book</button>
            </div>
        </form>
        @endif

        @if($addBook)
        <!-- Add Book Form -->
        <form class="max-w-sm mx-auto" wire:submit.prevent="addedbook">
            <div class="mb-5">
                <label for="photos" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your Photo</label>
                <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" type="file" wire:model="photos" required>
            </div>
            <div class="mb-5">
                <label for="newbooktitle" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Book title</label>
                <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" type="text" wire:model="newbooktitle" placeholder="title" required>
            </div>
            <div class="mb-5">
                <label for="newbookshortdescription" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Short Description</label>
                <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" type="text" wire:model="newbookshortdescription" placeholder="short_description" required>
            </div>
            <div class="mb-5">
                <label for="newbookdetail" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Details</label>
                <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" type="text" wire:model="newbookdetail" placeholder="details" required>
            </div>
            <div class="mb-5">
                <button type="submit">Add book</button>
            </div>
        </form>
        @endif

    </div>
</div>
