<div>
    <input type="file" id="myFiles" multiple>
    
    @foreach( $reports as $index => $report )
        <div>
        @isset($report['fileName'] ) {{ $report['fileName'] }} @endisset
        @isset($report['progressPercent'])
            <div class="mt-2 bg-blue-50" >Uploading... {{ $report['progressPercent'] }}%
                <progress max="100" value="{{ $report['progressPercent'] }}"></progress>
            </div>
        @endisset
        </div>
    @endforeach
  
    <script>

        const filesSelector = document.querySelector('#myFiles');
        filesSelector.addEventListener('change', () => {
            const fileList = [...filesSelector.files];
          
            fileList.forEach((file, index) => {
                
                @this.set('reports.'+index+'.fileName', file.name, true );
                @this.set('reports.'+index+'.fileSize', file.size, true );
                @this.set('reports.'+index+'.progressPercent', 0, true );
                livewireUploadChunk( index, file, 0 );

            });
        });

        function livewireUploadChunk( index, file, start ){

            // From the start to this end is the chunk of the file
            const chunkEnd = Math.min( start + @js($chunkSize), file.size );
            const chunk    = file.slice( start, chunkEnd );
            console.log('chunking upload for file at index ',index, ' at ',start, ' and end ',chunkEnd, 'filesize is ', file.size);

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
