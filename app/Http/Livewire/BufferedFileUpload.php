<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;

class BufferedFileUpload extends Component
{  
    public function getUniqueId()
    {
        $uniqueId = $this->generateUniqueFileId();
        $this->dispatchBrowserEvent(
            'unique-id-generated', ['uniqueId'=>$uniqueId]
        );
    }

    function generateTimeId()
    {
        return floor(microtime(true) * 1000);
    }

    function generateUniqueFileId()
    {
        $folderName = $this->generateTimeId();
        $path = 'tmp/'.$folderName;
        while( Storage::exists($path) ){
            Log::info('path exists! generating new path. previous was '.$path);
            $folderName .= $this->generateTimeId();
            $path = 'tmp/'.$folderName;
        }
        Storage::makeDirectory($path);
        return $folderName;
    }
    
    public function render()
    {
        return view('livewire.buffered-file-upload');
    }
}
