<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\TemporaryUploadedFile;
use Illuminate\Support\Facades\Storage;
use Log;
class MultipleFileUploader extends Component
{
    use WithFileUploads;
    public $uploads   = [];
    public $chunkSize = 5_000_000; // 5MB

    public function updatedUploads( $value, $key )
    {
        list($index, $attribute) = explode('.',$key);
        if( $attribute == 'fileChunk' ){
            $fileDetails = $this->uploads[intval($index)];
            
            // Final File
            $fileName  = $fileDetails['fileName'];
            $finalPath = Storage::path('/livewire-tmp/'.$fileName);  
            
            // Chunk File
            $chunkName = $fileDetails['fileChunk']->getFileName();
            $chunkPath = Storage::path('/livewire-tmp/'.$chunkName);
            $chunk      = fopen($chunkPath, 'rb');
            $buff       = fread($chunk, $this->chunkSize);
            fclose($chunk);

            // Merge Together
            $final = fopen($finalPath, 'ab');
            fwrite($final, $buff);
            fclose($final);
            unlink($chunkPath);

            
            // Progress
            $curSize = Storage::size('/livewire-tmp/'.$fileName);
            $this->uploads[$index]['progress'] = 
            $curSize/$fileDetails['fileSize']*100;
            if( $this->uploads[$index]['progress'] == 100 ){
                $this->uploads[$index]['fileRef'] = 
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
