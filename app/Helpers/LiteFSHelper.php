<?php
namespace App\Helpers;

use Log;

class LiteFSHelper
{
    /**
     * PUBLIC 
     */
    public function __construct()
    {
        $this->primaryNodeId = $this->readPrimaryIdFromConf();
        Log::info( 'primary node id retrieved is '.$this->primaryNodeId );
    }

    public function getPrimaryNodeId()
    {
        return $this->primaryNodeId;
    }

    public function forwardWriteRequest()
    {
        if( empty($this->getPrimaryNodeId()) || env('FLY_REGION') === 'test' )
            return false;
        else
            return true;
    } 

    /**
     * PRIVATE
     */

    function getPathToPrimaryConf()
    {
        return '/var/www/html/storage/database/.primary';#base_path().'/'.env('LITEFS_DB_DIR').'/.primary';
    }

    function readPrimaryIdFromConf()
    {
            
        $path = $this->getPathToPrimaryConf();
        Log::info( 'Base path primary node is '.$path );

        if( file_exists( $path ) ) 
           return file_get_contents( $path );

        return '';
    }

    

}

