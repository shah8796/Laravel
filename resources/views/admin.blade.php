<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @livewireStyles
    <script src="https://cdn.jsdelivr.net/alpinejs/2.8.0/alpine.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
    @vite('resources/css/app.css')
</head>
<body>
    <div>
        <livewire:administrator />
        
    </div>
    @livewireScripts
</body>
</html>