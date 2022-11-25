<div className="px-10">
    <div class="w-full block flex-grow lg:flex lg:items-center lg:w-auto">
        <div class="text-sm lg:flex-grow">
            <a id="current-rows" href="#" class="block mt-4 lg:inline-block lg:mt-0 mr-4">
            Current Rows 0 
            </a>

            <a href="#" class="block mt-4 lg:inline-block lg:mt-0 mr-4">
                Added Rows {{ count($dataRows ) }} Max Rows {{ $totalRows }}
            </a>
        </div>
        <div> 
            <input id="search_bar" type="text" wire:model.debounce.500ms="filters.search"  placeholder="Search" class="bg-gray-50 border border-gray-300 ">
            <!--Replaced polling accumulation with nextpage allowance accumulation, check line 80 below-->
            <!--if( count($dataRows) < $totalRows )
                <div wire:poll.5s>
                    Loading more data... 
                    { $this->nextPageData() }}
                </div>
            endif-->
        </div>
    </div>
   
    <div class="relative overflow-x-auto shadow-md rounded-lg">
        
        <table class="w-full text-sm text-left text-gray-500" id="myTable">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <th><div class="py-3 px-6 flex items-center" >URL</div></th>
                <th><div class="py-3 px-6 flex items-center" >Source</div></th>
                <th><div class="py-3 px-6 flex items-center" >ID</div></th>
                <th><div class="py-3 px-6 flex items-center" >Lead ID</div></th>
            </thead>
            <tbody id="tbody" wire:ignore>
            </tbody>
        </table>  
    </div>
    <nav role="navigation" aria-label="Pagination Navigation" class="flex justify-between" >
        <button onclick="prevPage()">Prev</button>
        <button onclick="nextPage()">Next</button>
    </nav>

    <script>
        var mTable   = document.getElementById("myTable");
        var myData   = @js($dataRows);//JSON.parse('<?php echo json_encode($dataRows) ?>');
        var page     = 1;
        var startRow = 0;
        var filters  = {};
        refreshPage();

       
        window.addEventListener('data-updated', event => {
            console.log(event.detail);
            if( event.detail.reset ){
                console.log('reseting');
                myData = [];
                page = 1;
            }
            myData.push(...event.detail.newData)
            refreshPage();
        });
        
        function filtersAvailable()
        {
            return ( filters.search != '' && filters.search != undefined );
        }

        function calculatePageStartRow( mPage )
        {
            console.log('Calculating start row for page ', mPage);
            return (mPage*10)-10;
        }
    
        function nextPage()
        {   
            // We can move to the next page since if there is anymore data, we can always
            if( calculatePageStartRow( page+1 ) < myData.length ){
                page = page+1;
                refreshPage();
            }
            // Get more next page allowance, instead of relying on livewire poll commented out above
            @this.nextPageData();
        }
    
        function prevPage()
        {
            if( page > 1 ){
                page = page-1;
                refreshPage();
            }
        }
    
        function refreshPage()
        {
            document.getElementById("current-rows").innerHTML = 'Current Rows: '+myData.length;
            startRow = calculatePageStartRow(page);
            document.getElementById("tbody").innerHTML = '';
            for(let row=startRow; row<myData.length && row<startRow+10; row++){
                let item = myData[row];
                var rowTable = mTable.getElementsByTagName('tbody')[0].insertRow(-1);
                
                if(item['lead_article_id']!=null){
                    rowTable.className = "pl-10 bg-gray-200";
                    var className = "pl-10";   
                }else
                    var className = ""; 

                var cell1 = rowTable.insertCell(0);
                var cell2 = rowTable.insertCell(1);
                var cell3 = rowTable.insertCell(2);
                var cell4 = rowTable.insertCell(3);

                cell1.innerHTML = '<div class="py-3 '+className+' px-6 flex items-center">' + item['url'] + '</div>';
                cell2.innerHTML = '<div class="py-3 '+className+' px-6 flex items-center">' + item['source'] + '</div>';
                cell3.innerHTML = '<div class="py-3 '+className+' px-6 flex items-center">' + item['id'] + '</div>';
                cell4.innerHTML = '<div class="py-3 '+className+' px-6 flex items-center">' + item['lead_article_id'] + '</div>';
            }
            
        }
    </script>  
</div>




