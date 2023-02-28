<?php

namespace App\Http\Livewire;

use Log;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Livewire\TemporaryUploadedFile;

class MultipleFileUploader extends Component
{
    use WithFileUploads;

    // Base 
    public $reports=[];
    public $progressPercent;
    
    // Chunking
    public $chunkSize = 2000000; // 2M
    

    public function updatedReports( $value, $key )
    {
        
        $index  = intval(explode('.',$key)[0]);
        $report = $this->reports[$index];
        if( isset($report['fileChunk']) ){
         
            $finalPath = Storage::path('/livewire-tmp/'.$report['fileName']);
            $tmpPath   = Storage::path('/livewire-tmp/'.$report['fileChunk']->getFileName());
            $file = fopen($tmpPath, 'rb');
            $buff = fread($file, $this->chunkSize);
            fclose($file);

            $final = fopen($finalPath, 'ab');
            fwrite($final, $buff);
            fclose($final);
            unlink($tmpPath);
            $curSize = Storage::size('/livewire-tmp/'.$report['fileName']);
            if( $curSize == $report['fileSize'] ){
                Log::info('completed merging1');
                $this->reports[$index]['fileRef'] = TemporaryUploadedFile::createFromLivewire('/'.$report['fileName']);
            }

        }
    
    }

    public function render()
    {
        return view('livewire.multiple-file-uploader');
    }
}
