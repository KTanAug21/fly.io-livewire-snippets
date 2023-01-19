<?php

namespace App\Http\Controllers;

use DB;
use Log;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response as FacadeResponse;

class DocumentController extends Controller
{
    public function index()
    {
        $documents = Document::all();
        return view('documents.index',[
            'documents'=>$documents
        ]);
    }

    public function display($id)
    {
        $pdfDetails = Document::find($id);

        // Decide replay
        if( $pdfDetails->region_id != env('FLY_REGION') && env('FLY_REGION') != 'test'){     

            // Replay to identified region
            return response('', 200, [
                'fly-replay' => 'region='.$pdfDetails->region_id ,
            ]);

        }else{

            // FileName
            $fileName = explode('/', $pdfDetails->full_path);
            $fileName = $fileName[(count($fileName))-1];

            // Go ahead and access PDF 
            $content = Storage::disk('local')
            ->get( $pdfDetails->full_path );
            $mimeType = Storage::mimeType( $pdfDetails->full_path );

            // Respond
            return FacadeResponse::make($content, 200, [
                'Content-Type' =>  $mimeType,
                'Content-Disposition' => "inline;filename='$fileName';region='".env('FLY_REGION')."'"
            ]);

        }
    }
  
}
