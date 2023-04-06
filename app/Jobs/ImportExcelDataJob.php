<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportExcelDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(protected $rows){}

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(\App\Http\Services\ExcelRowProcessor $processor)
    {
        foreach( $this->rows as $key=> $row ){
            $processor->process($key, $row);
        }
    }
}
