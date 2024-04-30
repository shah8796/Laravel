

document.addEventListener('DOMContentLoaded', function () {
    const readmore = document.getElementById('readmore');
    readmore.addEventListener('click', function (event) {
        event.preventDefault();
        const details = document.querySelector('.details');
        details.classList.remove('hidden');
    });
    const favoriteStars = document.querySelectorAll('.favorite-star');

    favoriteStars.forEach(function(star) {
        star.addEventListener('click', function() {

            console.log("hello");
            const bookId = this.getAttribute('data-book-id');
            isFavorite = !isFavorite;
        if (isFavorite) {
            favoriteStar.innerHTML = '&#9733;'; // Filled star
            // Add logic to mark book as favorite
        } else {
            favoriteStar.innerHTML = '&#9734;'; // Hollow star
            // Add logic to remove book from favorites
        }
            $.ajax({
                type: 'POST',
                data: { 'bookid': bookId },
                url: 'favorite',
                success: function(response) {
                    // Handle success response
                    console.log(response);
                    // You can update the UI here if needed
                },
                error: function(xhr, status, error) {
                    // Handle error response
                    console.error('Error favoriting book:', error);
                }
            });
            
        });
    });
});