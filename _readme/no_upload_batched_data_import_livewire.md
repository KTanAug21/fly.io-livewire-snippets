# No-Upload, Batched Import of Excel Data with SheetJS CE and Livewire

In [this article](https://fly.io/laravel-bytes/batch-read-excel-livewire/) we skip spreadsheet file upload, and instead directly upload its data from the browser to the server with [SheetJS CE](https://docs.sheetjs.com/docs/), [Web Workers](https://docs.sheetjs.com/docs/demos/bigdata/worker/), and [Livewire](https://laravel-livewire.com/docs/2.x/quickstart)!


## Relevant files
1. Our [Livewire view](https://github.com/KTanAug21/fly.io-livewire-snippets/blob/master/resources/views/livewire/excel-importer.blade.php) 
2. Our [Livewire component](https://github.com/KTanAug21/fly.io-livewire-snippets/blob/master/app/Http/Livewire/ExcelImporter.php)
3. Our [Laravel Job](https://github.com/KTanAug21/fly.io-livewire-snippets/blob/master/app/Jobs/ImportExcelDataJob.php) that will be queued to process our data in the background
4. And a [sample Service class](https://github.com/KTanAug21/fly.io-livewire-snippets/blob/master/app/Http/Services/ExcelRowProcessor.php) to actually process the data 


