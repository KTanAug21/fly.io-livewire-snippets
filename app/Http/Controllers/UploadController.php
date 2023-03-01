<?php

namespace App\Http\Controllers;

class UploadController extends Controller
{
    /**
     * Returns the index page for the Documents module
     */
    public function index()
    {
       
        return view('uploads.index');
    }
  
}
