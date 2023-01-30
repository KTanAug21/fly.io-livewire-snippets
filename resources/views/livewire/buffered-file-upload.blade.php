<div>
    <form wire:submit.prevent="submit" wire:ignore>
        @csrf
        <input type="file" id="myFile"/>
        <button type="button" >Submit</button>
    </form>

    <script>
        const fileInput = document.querySelector('#myFile');
        const token     = document.querySelector('[name=_token]');
        const chunkSize = 1000000; // 1MB per chunk
        let chunkCount;
        let file;
        
        fileInput.addEventListener('change',()=>{

            // Update file reference
            file = fileInput.files[0];

            // Determine the number of chunks to send
            chunkCount = Math.ceil(file.size/chunkSize);

            // Notify server of new file to upload
            @this.getUniqueId();

        });

        // Now we have our uniqueId folder to upload our chunks to
        window.addEventListener('unique-id-generated', event => {
            
            let uniqueId = event.detail.uniqueId;
            console.log('received unique id:', uniqueId, ' for ', file.name);
            uploadChunk( file, 0, uniqueId );

        });

        function uploadChunk(file, start, uniqueId)
        {
            console.log('uploading slice',start);

            // Get next slice
            const chunkEnd  = Math.min( start + chunkSize, file.size );
            const chunk     = file.slice(start,chunkEnd); 
            const chunkForm = new FormData();
            chunkForm.append('file', chunk, file.name);
            chunkForm.append('folderId',uniqueId);
            chunkForm.append('chunkId',Math.floor(start/chunkSize));
            chunkForm.append('chunkCount', chunkCount);
            chunkForm.append('chunkSize',chunkSize);
            chunkForm.append('fileName', file.name);

            // New request
            let request = new XMLHttpRequest()
            request.open('POST', '/files/upload-part');
            request.setRequestHeader('X-CSRF-TOKEN',  token.value);

            // Upload listener
            request.upload.addEventListener('load', () => {
                console.log("oReq.response", request.response);
                start += chunkSize;	
                if(start<file.size){
                    // Create the new chunk
                    console.log('uploading next chunk');
                    uploadChunk( file, start, uniqueId );
                }else{
                    console.log('completeD ALL PARTS!');
                }
            });

            // Send!
            request.send(chunkForm);
        }
    </script>
</div>
