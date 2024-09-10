## Finally deployed through Fly.io!
[Livewire](https://laravel-livewire.com/) apps--any apps really--are faster close to your users. 

Deploy your Laravel-Livewire app in a jiffy with [Fly.io](https://fly.io/docs/laravel/), wherever your users may be!

I finally deployed mine close to me in my own little space. 

Visit https://ktan-app.fly.dev/, up in [Fly.io](https://fly.io/) :heartbeat:


## Set up
1. Clone the repository `git clone git@github.com:KTanAug21/fly.io-livewire-snippets.git`
2. Get our vendor packages, run `composer update`
3. Set up your [.env](https://github.com/laravel/laravel/blob/master/.env.example) file with your preferred database connection, may I recommend a simple sqlite for this demo?
```
DB_CONNECTION="sqlite"
DB_DATABASE="/path/to/app/folder/database.sqlite"
```
4. Run the migration `php artisan migrate`
5. When following the article "Hoarding Order with Livewire", run the seeder `php artisan db:seed` or  `php artisan migrate:fresh --seed`
5. Run `php artisan serve`
6. Follow the Tailwind setup [here](https://tailwindcss.com/docs/guides/laravel), but in short the most you'll need to run is `npm install -D tailwindcss postcss autoprefixer`, afterwards, run `npm run dev`

## Deploying through Fly.io
1. Follow the deployment instructions [here](https://fly.io/docs/laravel/).
2. This repository is using an sqlite database stored in `/storage/database/`. Please follow [Fly setup here](https://fly.io/docs/laravel/the-basics/databases/#sqlite-in-a-laravel-fly-app) to Volumize the storage folder and persist data in it, including the `/storage/database/database.sqlite`.
3. This repo is configured with Github CI Actions for auto deployment! So any git push to the repo sends an automatic re-deployment of my Fly App! Read how to quickly [set up here](https://fly.io/docs/laravel/the-basics/github-actions/).
3. You might run into "Mix manifest not found" error. If so, make sure to remove any mix('...') found in your application. In this repository's case, the `resources/views/welcome.blade.php` came with a `<link href="{{ mix('/css/app.css') }}" rel="stylesheet">` I had to remove.

## Constitution
1. This is a [Laravel](https://laravel.com/) project :)
2. Makes use of [Livewire](https://laravel-livewire.com/docs/2.x/quickstart#install-livewire)
3. And [Tailwind](https://tailwindcss.com/docs/guides/laravel), hence the `npm run dev` above
4. Flown with [Fly.io](https://fly.io/) in [two regions]() of our world.
5. SQLite data synced between FRA and AMS instances with [LiteFS](https://fly.io/docs/laravel/advanced-guides/global-sqlite-litefs/)

# Hoarding Order With Livewire

Tables with grouped rows have three kinds of rows:
1. A "Normal" data that does not belong to any group
2. A "Lead" data that leads a group. It is always followed by "Sub" rows.
3. A "Sub" data that belongs to a group. It always follows a "Lead" row, or another "Sub" row following its "Lead" row.

Paginating a table that contains grouped rows can become complicated when implemented via server-side pagination. 
For example, imagine only 10 rows can be displayed per page, and the 9th data is a Lead with 3 Sub rows. The 9th row will be the 9th data ofcourse, acting as a Lead row.
The 10th row of the page will hold the 1st Sub data, while the remaining two Subs will take up the 1st and 2nd row positions in the next page.
To implement this display, the server would have to take note of the remaining 2 rows to show in the next page, as well as what is the next data to show after the remaining Sub rows. 

Client-side pagination on the other hand does not need to keep track of this, it would need only to display data from a starting index to the last. 
The only downside in client-pagination is the bulkiness of an entire data set it would have to download to paginate the data.

## Client-Pagination + Data Accumulation
This is easily done through Livewire. I have written an article on this here: https://fly.io/laravel-bytes/hoarding-order/

We can make client-pagination work without downloading entire data sets. We can instead rely on data accumulation.
The client-paginated table will paginate based on indices on initial data it has, while we fetch more data in the background to complete the entire dataset.


## Tips on Data Accumulation
Read my full article here: https://fly.io/laravel-bytes/offloading-data-baggage/

1. Dont accumulate data from the server, we don't want to send back larger and larager datasets to the client
2. Accumulate data in the client, since the client is receiving the data batches from the server
3. Data accumulation in the client might take up too much space in user devices, so it's better to find conditions when we would want to reset the list.
For example, during table filter, the only relevant data would be those under the filter scope. Other data in the accumulated list we have are not relevant, so, it's safe to clear the accumulated data
and replace with relevant data under the filter's scope.

## Replacing Polling
In the early version of the ArticleTable.php, data accumulation was done through periodically calling the nextPageData method through Livewire:poll.
 
Polling aimlessly for more data is a bit extravagant, and will definitely take too much space in our client devices in no time.

To fix this, let's add a direction to our request for "data allowance". Every time our users clicks on Next Page button, that's the time when we ask for more data allowance by calling nextPageData.

# Article Readme's
1. [Hoarding Order With Livewire](https://github.com/KTanAug21/fly.io-livewire-snippets/blob/master/_readme/hoard_order_livewire.md)
2. [Delayed Display of Isolated PDFs with Fly-Replay and Livewire](https://github.com/KTanAug21/fly.io-livewire-snippets/blob/master/_readme/display_isolated_fly_replay_livewire.md)
3. [Chunked File Upload with Livewire](https://github.com/KTanAug21/fly.io-livewire-snippets/blob/master/_readme/chunked_file_upload_livewire.md)
4. [Concurrent, Chunked, Multi-File Upload with Livewire](https://github.com/KTanAug21/fly.io-livewire-snippets/blob/master/_readme/multiple_file_upload_livewire.md)
5. [No-Upload, Batched Import of Excel Data with Livewire](https://github.com/KTanAug21/fly.io-livewire-snippets/blob/master/_readme/no_upload_batched_data_import_livewire.md)



