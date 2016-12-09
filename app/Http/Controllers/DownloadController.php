<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DownloadController extends Controller
{
   public function download_app(Request $request){
       //PDF file is stored under project/public/download/info.pdf
        $file="./download/Gaen.apk";
        return response()->download($file, 'Gaen.apk');
    }
}
