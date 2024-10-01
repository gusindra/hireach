<?php

namespace App\Http\Controllers;

use App\Jobs\CellularUpdateValidateJob;
use App\Jobs\SkiptraceUpdateJob;
use App\Jobs\WhatsappValidateUpdateJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ContactValidationResutController extends Controller
{
    public function importUpdateValidation(Request $request)
    {

        $filePath1 = 0;
        $filePath2 = 0;
        $filePath3 = 0;

        if (App::environment('production')) {
            $files = Storage::disk('ftp')->allFiles('/Out');;
            foreach($files as $f){
                if( strpos( $f, 'SKIPTRACE' ) !== false && strpos( $f, date('Ymd') ) !== false) $filePath1 = Storage::disk('ftp')->path($f);
                if( strpos( $f, 'CELLULARNO' ) !== false && strpos( $f, date('Ymd') ) !== false) $filePath2 = Storage::disk('ftp')->path($f);
                if( strpos( $f, 'WHATSAPP' ) !== false && strpos( $f, date('Ymd') ) !== false) $filePath3 = Storage::disk('ftp')->path($f);
            }
            //$filePathSource = Storage::disk('ftp')->path('/Out');
            //File::copyDirectory($filePathSource, $pathDestination);
        }else{
            $filePath1 = storage_path('app/datawiz/RESULT SKIPTRACE_NO_20240820.xlsx');
            $filePath2 = storage_path('app/datawiz/RESULT CELLULARNO_20240819.xlsx');
            $filePath3 = storage_path('app/datawiz/RESULT WHATSAPP_20240819.xlsx');
        }

        if ($filePath1) {
            //$pathSource = Storage::disk('ftp')->getDriver()->getAdapter()->applyPathPrefix(null);
            // get destination directory (already exists)

            // copy all the files from source to destination directories

            SkiptraceUpdateJob::dispatch($filePath1);
        } else {
            Log::debug('File not found: '.$filePath1);
            //return redirect()->back()->with('error', 'File not found: '.$filePath1);
        }

        if ($filePath2) {
            CellularUpdateValidateJob::dispatch($filePath2);
        } else {
            Log::debug('File not found: '.$filePath2);
            //return redirect()->back()->with('error', 'File not found: '.$filePath2);
        }

        if ($filePath3) {
            WhatsappValidateUpdateJob::dispatch($filePath3);
        } else {
            Log::debug('File not found: '.$filePath3);
            //return redirect()->back()->with('error', 'File not found: '.$filePath3);
        }
    }
}
