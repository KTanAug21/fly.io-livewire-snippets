<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ShowPdf extends Component
{
    public $recordId;
    public $loadAllowed = false;

    public function setRecordId( $recordId )
    {
        $this->recordId = $recordId; 
    } 
    
    public function allowFileLoading()
    {
        $this->loadAllowed = true;
    }

    public function render()
    {
        return view('livewire.show-pdf');
    }
}
