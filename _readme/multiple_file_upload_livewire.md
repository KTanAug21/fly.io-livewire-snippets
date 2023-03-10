# Concurrent, Chunked, Multi-File Upload with Livewire!

In [this article](https://fly.io/laravel-bytes/multi-file-upload-livewire/) we upload multiple files in concurrent requests, and optionally, in chunks!

Livewire provides us its upload api to make this customization of its multi-file upload hassle free.

## Relevant files
1. Our [Livewire view](https://github.com/KTanAug21/fly.io-livewire-snippets/blob/master/resources/views/livewire/multiple-file-uploader.blade.php) 
2. Our [Livewire component](https://github.com/KTanAug21/fly.io-livewire-snippets/blob/master/app/Http/Livewire/MultipleFileUploader.php)

## Footnotes
1. In case anyone wants to persist their previously selected files whenever they select new files, you can read on a possible implementation logic here: https://laracasts.com/discuss/channels/livewire/multiple-image-upload-in-the-same-form ( from user ktan-lara )!
