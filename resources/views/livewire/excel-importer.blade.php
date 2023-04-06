<div>
    <h1 
    style="-webkit-text-stroke: 1px black" 
    class="text-5xl font-extrabold text-transparent bg-clip-text 
    bg-gradient-to-r 
    to-pink-100 
    via-pink-200
    from-pink-100
    ">Import Excel Datasdasda</h1>

    <form onsubmit="return process()">
        <input type="file" id="myCSV" />
        <input type="submit" class="cursor-pointer">
    </form>

    <div id="errors">
        @foreach( $errors->all() as $error )
        <div> {{ $error }} </div>
        @endforeach
    </div>

    <script lang="javascript" src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js" ></script>
   
    <script>
        var reader = new FileReader();
        var el = document.querySelector('#myCSV');

        /* Call worker*/
        function process(){
            console.log('starting import');
            mWorker.postMessage(el.files[0]);
            return false;
        } 

        var mWorker = new Worker(URL.createObjectURL(new Blob([`\ 
            // Import SheetJS CE in web worker
            importScripts("https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js");

            self.addEventListener('message', (e) => {

                // The file we passed is read as "e.data"
                const reader = new FileReader();
                reader.readAsArrayBuffer(e.data);

                // Parse file
                reader.onload = function(event) {
                    // Parsed content
                    var workbook = XLSX.read(event.target.result);
                    event.target.result = null;

                    // Go through each sheet
                    workbook.SheetNames.forEach(function(sheetName) {
                        // Current sheet
                        var sheet = workbook.Sheets[sheetName];

                        // Include header param to return array of arrays
                        var param = {header:1};
                        var rows  = XLSX.utils.sheet_to_json(sheet, param);
                        rows.shift();
                        
                        // Pass a sheet's rows back to browser
                        postMessage({ rows });
                        rows = null;

                    });
                }

            });

        `]) ));

        /* Receive from worker*/
        var sheetRows = [];
        mWorker.onmessage = function(e) { 
            sheetRows.push( e.data.rows ); 
            batchSend( sheetRows.length-1 );
        };

        /* Send current batch for sheet identified by index */
        function batchSend( index ){

            // Some truths our batching depends on for this sheet
            var batchSize = 100;
            var rowSize   = sheetRows[index].length;

            // Get batch range
            var start = 0;
            var end =  Math.min( start + batchSize, rowSize );

            // Get sliced rows range for current sheet
            var range = sheetRows[index].slice( start, end );

            // Remove range from our current sheet, since `range` holds it
            sheetRows[index] = sheetRows[index].slice( end, rowSize );

            // Send range to server
            @this.importData( range, index );

        }

        /* Send in next batch if applicable for sheet identified by index */
        window.addEventListener('import-processing',function(event){
            var sheetIndex = event.detail.sheetIndex;
            if( sheetRows[sheetIndex].length > 0 ){
                batchSend( sheetIndex );
            }else{
                alert( sheetIndex + ' Sheet\'s Data has been sent for processing!');
            }
        });

        

    </script>
</div>
