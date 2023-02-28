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
        Log::info('updated '.$key);
        $index = intval(explode('.',$key)[0]);
        $fileDetails = $this->reports[$index];
        if( isset($fileDetails['fileChunk']) ){
            Log::info('fileCHunk uploaded!');
            $fileName  = $fileDetails['fileName'];
            $finalPath = Storage::path('/livewire-tmp/'.$fileName);    

            $chunkName = $fileDetails['fileChunk']->getFileName();
            $chunkPath = Storage::path('/livewire-tmp/'.$chunkName);
            $chunk      = fopen($chunkPath, 'rb');
            $buff       = fread($chunk, $this->chunkSize);
            fclose($chunk);

            $final = fopen($finalPath, 'ab');
            fwrite($final, $buff);
            fclose($final);
            unlink($chunkPath);

            $curSize = Storage::size('/livewire-tmp/'.$fileName);
            $this->reports[$index]['progress'] = 
            $curSize/$fileDetails['fileSize']*100;
            Log::info( 'FIle size of '.$fileName.' is now '. $this->reports[$index]['progress']);
            if( $this->reports[$index]['progress'] == 100 ){
                $this->reports[$index]['fileRef'] = 
                TemporaryUploadedFile::createFromLivewire(
                  '/'.$fileDetails['fileName']
                );
            }
        }
    
    }

    public function render()
    {
        return view('livewire.multiple-file-uploader');
    }
}
