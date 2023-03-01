<div>
    <input type="file" id="myFiles" multiple>
    
    
    @foreach( $reports as $index => $report )
        @if( isset($report['fileName']) &&  $report['progress'] )
            <div class="mt-2 bg-blue-50 rounded-full pt-2 pr-4 pl-4 pb-2">
                <label class="flow-root">
                    <div class="float-left">{{ $report['fileName'] }}</div>
                    <div class="float-right">{{ $report['progress'] }}%</div>
                </label>
                <progress max="100" wire:model="reports.{{$index}}.progress" class="h-1 w-full bg-neutral-200 dark:bg-neutral-60"/>
            </div>
        @endif
    @endforeach
  
    <script>

        const filesSelector = document.querySelector('#myFiles');
        filesSelector.addEventListener('change', () => {
            const fileList = [...filesSelector.files];
          
            fileList.forEach((file, index) => {
                
                @this.set('reports.'+index+'.fileName', file.name, true );
                @this.set('reports.'+index+'.fileSize', file.size, true );
                @this.set('reports.'+index+'.progress', 0, true );
                livewireUploadChunk( index, file, 0 );

            });
        });

        function livewireUploadChunk( index, file, start ){

            // From the start to this end is the chunk of the file
            console.log( "Chunk size is ",@js($chunkSize), " and file size is ", file.size );

            const chunkEnd = Math.min( start + @js($chunkSize), file.size );
            const chunk    = file.slice( start, chunkEnd );
            console.log('chunking upload for file ' + file.name +' at index ',index, ' at ',start, ' and end ',chunkEnd, 'filesize is ', file.size);

            @this.upload('reports.'+index+'.fileChunk', chunk, (n)=>{},()=>{},(e)=>{
                
                // Once done, proceed with next chunk
                if( event.detail.progress == 100 ){
                    start = chunkEnd;
                    if( start < file.size )
                        livewireUploadChunk( index, file, start );
                    
                }

            });
        }
    </script>
</div>
