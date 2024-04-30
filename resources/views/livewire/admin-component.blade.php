<div>
    @foreach ($users as $user)
    <div id="{{ $user->id }}" class="flex justify-between p-5">
        <span>{{ $user->name }}</span>
        <div>
            <button wire:click="viewUser({{ $user->id }})" class="bg-blue-200 rounded-md p-3 ml-2">View</button>
            <button wire:click="addUser" class="bg-blue-200 rounded-md p-3 ml-2">Add</button>
            <button wire:click="editUser({{ $user->id }})" class="bg-blue-200 rounded-md p-3 ml-2">Edit</button>
            <button wire:click="deleteUser({{ $user->id }})" class="bg-blue-200 rounded-md p-3 ml-2">Delete</button>
        </div>
    </div>
    @endforeach
</div>