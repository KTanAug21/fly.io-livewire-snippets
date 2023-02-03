<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

class BufferedFileUpload extends Component
{  
    use WithFileUploads;

    // Chunks info
    public $chunkSize  = 1000000; // 1MB
    public $chunkCount = 0;
    public $orderList  = [];

    // Uploaded chunk
    public $fileChunk;

    // Final file 
    public $fileName;
    public $finalPath;

    public function validateFile($request)
    {
        $fileTypes = ['pdf','csv','txt','xlx','xls'];
        if( in_array( $request->file->extension(),$fileTypes) ){
            return true;
        }else{
            return abort(422,'Please upload one of the following file types: '.json_encode($fileTypes));
        }
    }

    public function updatedFileChunk()
    {
      
        $this->orderList[] = $this->fileChunk->getFileName();
        if( count($this->orderList)==$this->chunkCount ){
           
            $finalPath = Storage::path('/livewire-tmp/'.$this->fileName);
          
            foreach($this->orderList as $order){
                $tmpPath = Storage::path('/livewire-tmp/'.$order);
                $file = fopen($tmpPath, 'rb');
                $buff = fread($file, $this->chunkSize);
                fclose($file);

                $final = fopen($finalPath, 'ab');
                fwrite($final, $buff);
                fclose($final);
          
                unlink($tmpPath);
            }
            $this->finalPath = $finalPath;

        }
 
    }
    
    public function render()
    {
        return view('livewire.buffered-file-upload');
    }
}
