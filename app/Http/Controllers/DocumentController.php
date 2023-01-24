<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Support\Facades\Storage;
use Log;

class DocumentController extends Controller
{
    /**
     * Returns the index page for the Documents module
     */
    public function index()
    {
        $documents = Document::all();
        return view('documents.index',[
            'documents'=>$documents
        ]);
    }

    /**
     * Display file directly in user's browser
     * 
     * @param int $id
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory 
     */
    public function display($id)
    {
        $pdfDetails = Document::find($id);
        Log::info('our config var value is '.config('app.fly_region') );
        
        // Decide replay
        if( $pdfDetails->region_id != config('app.fly_region') ){     

            // Replay to identified region
            return response('', 200, [
                'fly-replay' => 'region='.$pdfDetails->region_id ,
            ]);

        }else{

            // FileName
            $fileName = explode('/', $pdfDetails->full_path);
            $fileName = $fileName[(count($fileName))-1];

            // Accessible File Path
            $filePath = Storage::path( $pdfDetails->full_path );

            // Respond with File
            return response()->file( $filePath );

        }
    
    }
  
}
