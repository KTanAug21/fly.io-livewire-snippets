<div>
    <input type="file" id="myFiles" multiple>
    @foreach( $uploads as $i=>$upl )
        <div class="mt-2 bg-blue-50 rounded-full pt-2 pr-4 pl-4 pb-2">
            <label class="flow-root">
                <div class="float-left">{{ $upl['fileName'] }}</div>
                <div class="float-right">{{ $upl['progress'] }}%</div>
            </label>
            <progress max="100" wire:model="uploads.{{$i}}.progress" class="h-1 w-full bg-neutral-200 dark:bg-neutral-60"/>
        </div>
    @endforeach
    <script>
        const filesSelector = document.querySelector('#myFiles');
        let chnkStarts=[];
        
        filesSelector.addEventListener('change', () => {
            const fileList = [...filesSelector.files];
            
            fileList.forEach((file, index) => {
                @this.set('uploads.'+index+'.fileName', file.name );
                @this.set('uploads.'+index+'.fileSize', file.size );
                @this.set('uploads.'+index+'.progress', 0 );
                chnkStarts[index] = 0;
                livewireUploadChunk( index, file );
            });
        }); 

        function livewireUploadChunk( index, file ){
            // End of chunk is start + chunkSize OR file size, whichever is greater
            const chunkEnd = Math.min(chnkStarts[index]+@js($chunkSize), file.size);
            const chunk    = file.slice(chnkStarts[index], chunkEnd);

            @this.upload('uploads.'+index+'.fileChunk',chunk,(n)=>{},()=>{},(e)=>{
                if( e.detail.progress == 100 ){
                    chnkStarts[index] = 
                    Math.min( chnkStarts[index] + @js($chunkSize), file.size );

                    if( chnkStarts[index] < file.size )
                        livewireUploadChunk( index, file );
                }
            });
        }
        /*filesSelector.addEventListener('change', () => {
            const fileList = [...filesSelector.files];
            fileList.forEach((file, index) => {
                @this.set('uploads.'+index+'.fileName', file.name );
                @this.set('uploads.'+index+'.fileSize', file.size );
                @this.set('uploads.'+index+'.progress', 0 );
                
                chunkStarts[index] = 0;
                livewireUploadChunk( index, file );
            });
        });

        function livewireUploadChunk( index, file ){
            
            // Get the chunk
            const chunkEnd = Math.min( chunkStarts[index] + @js($chunkSize), file.size );
            var date       = Math.floor(Date.now() / 1000);
            const chunk    = file.slice( chunkStarts[index], chunkEnd );

            @this.upload('uploads.'+index+'.fileChunk',chunk,(n)=>{},()=>{},(e)=>{
                if( e.detail.progress == 100 ){

                    console.log(
                        file.name, ' prev value is ', chunkStarts[index], 
                        '; const:',startCnst,
                        '; let:', startLt, 
                        '; var:', startVar, 
                    ' ', date);

                    chunkStarts[index] = Math.min( startCnst + @js($chunkSize), file.size );
                    
                    if( chunkStarts[index] < file.size ){
                        console.log( 'calling upload for ', file.name, 'start at ',startCnst, ' waiting at  ms on date ', date );
                        livewireUploadChunk( index, file );
                    }
                }
            });
        };*/

    </script>
</div>