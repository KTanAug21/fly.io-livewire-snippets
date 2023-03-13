<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GeneralController extends Controller
{
    public function index()
    {
        // URL
        $currentUrl = rtrim( url()->full(), "/" );
        // MODULE
        $currentModule = explode('/',$currentUrl);
        $currentModule = $currentModule[ count($currentModule)-1 ];
       
        // MODULE VIEW
        return view($currentModule.'.index');
    }
}
