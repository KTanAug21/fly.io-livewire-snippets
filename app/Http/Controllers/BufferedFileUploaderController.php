<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Log;

class BufferedFileUploaderController extends Controller
{
    public function validateFile(Request $request)
    {
        $fileTypes = ['pdf','csv','txt','xlx','xls'];
        if( in_array( $request->file->extension(),$fileTypes) ){
            return true;
        }else{
            return abort(422,'Please upload one of the following file types: '.json_encode($fileTypes));
        }
    }
    
    public function uploadPart(Request $request)
    {
        $this->validateFile($request);
            
        Log::info('received folderId'.$request->folderId);
        Log::info('received chunkCount'.$request->chunkCount);
        Log::info('received chunkId'.$request->chunkId);

        $path = 'tmp/'.$request->folderId;

        // Add to folder
        $file = $request->file('file');
        $file->storeAs(
            $path,
            $request->chunkId
        );

        // Check if merge
        $files = Storage::files($path);
        if( count($files) == $request->chunkCount ){
            $finalPath = Storage::path($path.'/'.$request->fileName);
            for($i=0;$i<$request->chunkCount;$i++){
             
                $tmpPath = Storage::path($path.'/'.$i);
                Log::info('merging '. $tmpPath);

                $file = fopen($tmpPath, 'rb');
                $buff = fread($file, $request->chunkSize);
                fclose($file);
          
                $final = fopen($finalPath, 'ab');
                $write = fwrite($final, $buff);
                fclose($final);
          
                unlink($tmpPath);
            }
        }

        return response('', 200);
    }

}
