<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ShowPdf extends Component
{
    public $recordId;
    public $loadAllowed = false;

    /**
     * Updates the component's recordId 
     * 
     * @param int $id
     * @return null
     */
    public function setRecordId( $recordId )
    {
        $this->recordId = $recordId; 
    } 
    
    /**
     * Updates the loadAllowed to true
     * 
     * @param int $id
     * @return null
     */
    public function allowFileLoading()
    {
        $this->loadAllowed = true;
    }

    public function render()
    {
        return view('livewire.show-pdf');
    }
}
