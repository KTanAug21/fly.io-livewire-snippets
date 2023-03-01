<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Reports</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
       
        @livewireStyles
    </head>
    <body class="flex items-center justify-center min-h-screen">

    <div class="w-full max-w-6xl  pt-10 pl-10 pr-10">
        <h1 class="text-6xl font-normal leading-normal mt-0 mb-2 text-pink-800">Uploads</h1> 
        
        <livewire:multiple-file-uploader />
       
      
    </div>

    @livewireScripts
    </body>
</html>