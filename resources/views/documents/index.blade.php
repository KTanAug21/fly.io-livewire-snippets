<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Document Table</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
       
        @livewireStyles
    </head>
    <body class="flex items-center justify-center min-h-screen">

    <div class="w-full max-w-6xl">
        <h1 class="text-6xl font-normal leading-normal mt-0 mb-2 text-pink-800">Documents</h1> 
        <div class="flex justify-between">
            
            <div>
                <form action="/documents/upload" method="post" enctype="multipart/form-data">
                    @csrf
                    <div >Upload in {{ env('FLY_REGION')  }}</div>
                    <input type="file" name="pdf" >
                    <input type="hidden" name="region" value="{{ env('FLY_REGION') }}"/>
                    <button type="submit" class="bg-blue-500 text-white pt-2 pb-2 px-3 rounded-md" >Submit</button>
                </form>
            </div>
            <div>
                <form action="/documents/uploadfra" method="post" enctype="multipart/form-data">
                    @csrf
                    <div >Upload in FRA</div>
                    <input type="file" name="pdf" >
                    <button type="submit" class="bg-blue-500 text-white pt-2 pb-2 px-3 rounded-md" >Submit</button>
                </form>
            </div>
        </div>
        <div class="relative overflow-x-auto shadow-md rounded-lg">
            <table class="w-full text-sm text-left text-gray-500" id="myTable">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <th><div class="py-3 px-6 flex items-center" >Path</div></th>
                    <th><div class="py-3 px-6 flex items-center" >Region</div></th>
                    <th><div class="py-3 px-6 flex items-center" >Action</div></th>
                </thead>
                @foreach( $documents as $document )
                    <tr>
                        <td><div class="py-3 px-6 flex items-center" >{{ $document->full_path }} </div></td>
                        <td><div class="py-3 px-6 flex items-center" >{{ $document->region_id }} </div></td>
                        <td><button type="button" class="bg-green-200  pt-2 pb-2 px-3 rounded-md" onclick="checkFile({{ $document->id }})">View</button></td>
                    </tr>
                @endforeach
            </table>  
        </div>
        <br>
        @livewire('show-pdf', ['recordId'=>1])

    </div>

    @livewireScripts

    <script>
        const showFileComponent = document.getElementById("showFileComponent");
        function checkFile( recordId )
        {
            livewire.find(showFileComponent.getAttribute("wire:id")).setRecordId( recordId );
        }
    </script>

    </body>
</html>