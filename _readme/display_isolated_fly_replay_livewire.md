# Delayed Display of Isolated PDFs with Fly-replay and Livewire!

Running global instances of our Laravel applications allows us to reduce geographical latency for users across different regions. But with it comes the responsibility of addressing regional-isolation of not only data, but files as well.

In [this article](/laravel-bytes/displaying-fly-replay-livewire/) we address file isolation by talking with the right regional instance using fly-replay. We also add a cherry on top with the use of Livewire's `wire:init` directive to improve loading of pages displaying PDF files.

## Relevant files
1. We've added routes to a documents module in [`web.php`](https://github.com/KTanAug21/fly.io-livewire-snippets/blob/master/routes/web.php)
2. The [Documents controller](https://github.com/KTanAug21/fly.io-livewire-snippets/blob/master/routes/web.php), Documents view page listing our available PDFs and iframe to display a PDF. 
