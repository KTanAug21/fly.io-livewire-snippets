<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rules\File;
use App\Models\Document;
use Illuminate\Support\Facades\Storage;

use Log;

class DocumentCrudController extends Controller
{    

    public function uploadFra(Request $request)
    {
        // Validation
        $validated = $request->validate([
            'pdf' => [
                'required',
                File::types(['pdf'])
            ]
        ]);
       
        $file = $request->file('pdf');
        $originalName = $file->getClientOriginalName();

        // Straight save to db in the ams region ( primary ) 
        // File Upload in the fra regopm
        if( env('FLY_REGION') == 'ams' ){ 

            Document::create([
                'full_path'   => 'storage/uploads/'.$originalName,
                'region_id'   => 'fra' // File is stored in the accepting instance, so we better use this as the region of the instance saving the file
            ]);
            
        }

        // File Upload in the fra regopm
        if( env('FLY_REGION') == 'fra' ){ 
            Log::info('Uploading in '.env('FLY_REGION') );
            $file->storeAs(
                'storage/uploads',
                $originalName
            );
        }else{
            Log::info('forwarding to fra...');   
            // Replay to identified
            return response('', 200, [
                'fly-replay' => "region=fra",
            ]);
        }

    }
    
    public function upload(Request $request)
    {
        // Validation
        $validated = $request->validate([
            'pdf' => [
                'required',
                File::types(['pdf'])
            ],
            'region' => ['required','string']
        ]);
       
        // File Upload
        Log::info('Uploading in '.env('FLY_REGION') );
        $file = $request->file('pdf');
        $file->storeAs(
            'storage/uploads',
            $file->getClientOriginalName()
        );

        // Identify Primary to replay to
        $lfHelper = new \App\Helpers\LiteFSHelper();
        $replayTo = $lfHelper->getPrimaryNodeId();
     
        // Decide replay
        if( $lfHelper->forwardWriteRequest() ){     
            Log::info('forwarding to primary...');   
            // Replay to identified
            return response('', 200, [
                'fly-replay' => "instance=$replayTo",
            ]);
        }else{
            Log::info('DB update in '.env('FLY_REGION') . ' from '.$request->region);

            Document::create([
                'full_path'   => 'storage/uploads/'.$file->getClientOriginalName(),
                'region_id'   =>  $request->region // File is stored in the accepting instance, so we better use this as the region of the instance saving the file
            ]);
            return 'OKAY';
        }

    }
}
