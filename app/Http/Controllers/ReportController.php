<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Support\Facades\Storage;
use Log;

class ReportController extends Controller
{
    /**
     * Returns the index page for the Documents module
     */
    public function index()
    {
       
        return view('reports.index');
    }
  
}
