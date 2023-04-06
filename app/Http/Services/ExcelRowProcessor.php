<?php
namespace app\Http\Services;
use Log;

class ExcelRowProcessor
{
    function process( $key, $row )
    {
        Log::info( 'Processing '.$key.'th row:'.json_encode($row) );
    }
}