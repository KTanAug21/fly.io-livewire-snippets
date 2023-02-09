# Chunked File Upload with Livewire!

When a user uploads a file that exceeds our application's max request size, the upload will fail. 

In [this article](https://fly.io/laravel-bytes/chunked-file-upload-livewire/) we address large file upload by slicing our file into separate chunks and uploading each chunk separately to the server.

We do this hassle free with the help of Livewire!

## Relevant files
1. We can add our Livewire component, <livewire:chunked-file-upload /> in any view. As an example, the component is declared( but commented-out) in our [documents index page](https://github.com/KTanAug21/fly.io-livewire-snippets/blob/master/resources/views/documents/index.blade.php)
2. Then our [Livewire view](https://github.com/KTanAug21/fly.io-livewire-snippets/blob/master/app/resources/views/livewire/chunked-file-upload.blade.php) that handles selecting the file, slicing, and calling the component below to upload our chunks
3. Finally our [Livewire component](https://github.com/KTanAug21/fly.io-livewire-snippets/blob/master/app/Http/Livewire/ChunkedFileUpload.phpp) to receive and merge the chunks
