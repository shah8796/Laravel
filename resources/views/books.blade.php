<div id="bookview" class="grid grid-cols-1 md:grid-cols-2 gap-4 lg:grid-cols-3">
    @foreach ($books as $book)
    <div id="books" class="max-w-md bg-white p-5 shadow-lg rounded-lg overflow-hidden">
        <img class="w-full h-56 object-fill object-center" src="{{ asset('images/' . $book->image) }}" alt="Image">
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
                        {{-- <span id="{{$book->id}}" class="favorite-star text-yellow-500 cursor-pointer ml-2">&#9734;</span> --}}
                @else
                    <span class="text-gray-500 inline-block">Please log in to read more</span>
                @endauth
            </div>
            <div id="details_{{ $book->id }}" class="details hidden mt-4" >
                <p  class="mt-2 text-gray-600">{{ $book->details }}</p>
            </div>
        </div>
    </div>
    @endforeach
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
// document.addEventListener('DOMContentLoaded', function () {
//     const readmore = document.querySelectorAll('.readmore');
//     readmore.forEach(function(link) {
//         link.addEventListener('click', function (event) {
//             event.preventDefault();
//             const bookId = this.getAttribute('id'); // Get the ID of the clicked link
//             const details = document.getElementById('details_' + bookId); // Select the corresponding details element
            
//             console.log(details);
//             details.classList.remove('hidden');
//         });
//     });

//     const favoriteStars = document.querySelectorAll('.favorite-star');

//     favoriteStars.forEach(function(star) {
//         star.addEventListener('click', function() {
//             const bookId = this.getAttribute('id');
//             let isFavorite = this.classList.contains('favorited');
//             let updatedIsFavorite = !isFavorite; // Toggle the value

//             if (isFavorite) {
//                 this.innerHTML = '&#9734;'; // Hollow star
//                 this.classList.remove('favorited');
//                 // Add logic to remove book from favorites
//             } else {
//                 this.innerHTML = '&#9733;'; // Filled star
//                 this.classList.add('favorited');
//                 // Add logic to mark book as favorite
//             }

//             $.ajax({
//                 type: 'POST',
//                 data: { 'bookid': bookId ,'isFavourite':updatedIsFavorite,
//                 '_token': $('meta[name="csrf-token"]').attr('content')},
//                 url: '{{ route('favourite') }}',
//                 success: function(response) {
//                     // Handle success response
//                     console.log(response);
//                     // You can update the UI here if needed
//                 },
//                 error: function(xhr, status, error) {
//                     // Handle error response
//                     console.error('Error favoriting book:', error);
//                 }
//             });
//         });
//     });
// });
</script>
