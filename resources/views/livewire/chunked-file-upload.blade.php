<div>
    <form wire:submit.prevent="save" >
        @if($finalFile)
            Photo Preview:
            <img src="{{ $finalFile->temporaryUrl() }}">
        @endif
        <input type="file" id="myFile"/>
        <button type="button" id="submit" onclick="uploadChunks()">Submit</button>
    </form>

    <script>         
        function uploadChunks()
        {
            // File Details
            const file = document.querySelector('#myFile').files[0];
      
            // Sent along with next call
            @this.set('fileName', file.name, true);
            @this.set('fileSize',file.size,true);
            
            // Upload first chunk of file
            livewireUploadChunk( file, 0 );
        }
        
        function livewireUploadChunk( file, start ) 
        {
            // Get chunk from start
            const chunkEnd  = Math.min( start + @js($chunkSize), file.size );
            const chunk     = file.slice( start, chunkEnd ); 
            @this.upload('fileChunk', chunk, (uName)=>{}, ()=>{}, (event) => {
                // Progress callback.
                if( event.detail.progress == 100 ){
                    // We recursively call livewireUploadChunk from within itself
                    start = chunkEnd;
                    if( chnkStarts[index] < file.size ){
                        let _time = Math.floor((Math.random() * 2000) + 1);
                        console.log('sleeping ',_time,'before next chunk upload');
                        setTimeout( livewireUploadChunk, _time, file, start );
                    }
                }
            });     
        }
    </script>
</div>