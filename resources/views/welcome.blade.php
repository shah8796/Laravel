<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="X-CSRF-TOKEN" content="{{ csrf_token() }}">
    @vite('resources/css/app.css')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <title>Document</title>
</head>
<body >
    
    
    {{-- @yield('header') --}}
    @include('header')
    @include('books')
   
    
</body>

</html>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Get the form and bookview element
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
                    "_token": "{{ csrf_token() }}"
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
    });
    </script>