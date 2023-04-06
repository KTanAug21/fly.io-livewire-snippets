<?php

namespace App\Http\Livewire;

use App\Jobs\ImportExcelDataJob;
use Livewire\Component;
use Log;

class ExcelImporter extends Component
{
    protected $rules = [
        'rows.*.0' => 'required|numeric'
    ];

    public $rows;

    public function importData( $rows, $sheetIndex){
        try{
           
            $this->rows = $rows;
            $this->validate();
            $this->rows = [];
           
            ImportExcelDataJob::dispatch( $rows );
            $this->dispatchBrowserEvent('import-processing',[ 
                'sheetIndex' => $sheetIndex 
            ]);

        }catch(\Illuminate\Validation\ValidationException $e){

            $this->rows = [];
            $validator = $e->validator;
            foreach($validator->errors()->all() as $error  ){
               Log::info( 'found error'.$error );
            }
            throw $e;

        }
    }

    public function render()
    {
        return view('livewire.excel-importer');
    }
}
