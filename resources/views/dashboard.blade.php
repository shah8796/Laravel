<x-app-layout>
    

    <div class="py-12 bg-white text-black">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if (auth()->user()->is_admin)
                <a href="{{ route('admin') }}" class="bg-blue-100 m-5 rounded-md p-3">Admin</a>
                
            @endif
            
            
            
        
            <button id="fav" class="bg-blue-100 m-5 rounded-md p-3">
                Favourites
            </button>
            <button id="all" class="bg-blue-100 m-5 rounded-md p-3 ">
                ALL
            </button>
            <form  id="frm">
                @csrf
                <div class="flex flex-row justify-between items-center">
                    <input type="text" id="search" name="search" class="w-full h-8" placeholder="Search">
                    <button type="submit" class="h-8  bg-blue-100">search</button>

                </div>
            </form>

        
        @include("books")
        </div>
            {{-- @if (auth()->user()->is_admin)
                <a href="{{ route('admin') }}" class="bg-blue-100 m-5 rounded-md p-3">Admin</a>
                
            @endif
            
            
            
        
            <button id="fav" class="bg-white m-5 rounded-md p-5 ">
                Favourites
            </button>
            <button id="all" class="bg-white m-5 rounded-md p-5 ">
                ALL
            </button>
            <form  id="frm">
                @csrf
                <div>
                    <input type="text" id="search" name="search" class="w-full h-8" placeholder="Search">
                    <button type="submit" class="p-5 bg-blue">search</button>

                </div>
            </form>

        
        @include("books") --}}
    </div>
</x-app-layout>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
   document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('frm');
        const bookview = document.getElementById('bookview');
    
        // Add event listener to the form submission
        form.addEventListener('submit', function (e) {
            e.preventDefault(); // Prevent default form submission
    
            // Get the search input value
            const searchData = document.getElementById('search').value;
    
            // Send AJAX request
            $.ajax({
                type: 'POST',
                data: {
                    'search': searchData,
                    '_token': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ route('searchview') }}',
                success: function (response) {
                    // Update the bookview element with the response
                    bookview.innerHTML = response;
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText); // Log any errors
                }
            });
        });
    // Event delegation for readmore links
    document.addEventListener('click', function (event) {
        if (event.target.classList.contains('readmore')) {
            event.preventDefault();
            const bookId = event.target.getAttribute('id');
            const details = document.getElementById('details_' + bookId);
            details.classList.remove('hidden');
        }
    });
    

    // Event delegation for favorite-star icons
    document.addEventListener('click', function (event) {
        if (event.target.classList.contains('favorite-star')) {
            const bookId = event.target.getAttribute('id');
            let isFavorite = event.target.classList.contains('favorited');
            let updatedIsFavorite = !isFavorite;

            if (isFavorite) {
                event.target.innerHTML = '&#9734;';
                event.target.classList.remove('favorited');
                // Add logic to remove book from favorites
            } else {
                event.target.innerHTML = '&#9733;';
                event.target.classList.add('favorited');
                // Add logic to mark book as favorite
            }

            $.ajax({
                type: 'POST',
                data: {
                    'bookid': bookId,
                    'isFavourite': updatedIsFavorite,
                    '_token': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ route('favourite') }}',
                success: function (response) {
                    console.log(response);
                },
                error: function (xhr, status, error) {
                    console.error('Error favoriting book:', error);
                }
            });
        }
    });

    const btn = document.getElementById('fav');
    

    btn.addEventListener('click', function (e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            data: {
                '_token': $('meta[name="csrf-token"]').attr('content')
            },
            url: '{{ route('favouriteview') }}',
            success: function (response) {
                bookview.innerHTML = response;
            }
        });
    });
    const btnAll = document.getElementById('all');
    // const bookview = document.getElementById('bookview');

    btnAll.addEventListener('click', function (e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            data: {
                '_token': $('meta[name="csrf-token"]').attr('content')
            },
            url: '{{ route('allview') }}',
            success: function (response) {
                bookview.innerHTML = response;
            }
        });
    });
});

</script>

