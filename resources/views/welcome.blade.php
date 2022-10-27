<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Livewire Table</title>
        @vite('resources/css/app.css')
        <link href="{{ mix('/css/app.css') }}" rel="stylesheet">
        @livewireStyles
    </head>
    <body class="flex items-center justify-center min-h-screen">

    <div class="w-full max-w-6xl">
        <livewire:article-table />
    </div>

    @livewireScripts
    </body>
</html>