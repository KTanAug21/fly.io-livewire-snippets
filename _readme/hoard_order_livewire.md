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