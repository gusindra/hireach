<?php

namespace App\Http\Controllers;

use App\Jobs\CellularUpdateValidateJob;
use App\Jobs\SkiptraceUpdateJob;
use App\Jobs\WhatsappValidateUpdateJob;
use Illuminate\Http\Request;

class ContactValidationResutController extends Controller
{
    public function importUpdateValidation(Request $request)
    {
        $filePath1 = storage_path('app/datawiz/RESULT SKIPTRACE_NO_20240820.xlsx');
        $filePath2 = storage_path('app/datawiz/RESULT CELLULARNO_20240819.xlsx');
        $filePath3 = storage_path('app/datawiz/RESULT WHATSAPP_20240819.xlsx');


        if (file_exists($filePath1)) {
            SkiptraceUpdateJob::dispatch($filePath1);
        } else {
            return redirect()->back()->with('error', 'File not found: RESULT SKIPTRACE_NO_20240820.xlsx');
        }

        // if (file_exists($filePath2)) {
        //     CellularUpdateValidateJob::dispatch($filePath2);
        // } else {
        //     return redirect()->back()->with('error', 'File not found: RESULT CELLULARNO_20240819.xlsx');
        // }

        // if (file_exists($filePath3)) {
        //     WhatsappValidateUpdateJob::dispatch($filePath3);
        // } else {
        //     return redirect()->back()->with('error', 'File not found: RESULT WHATSAPP_20240819.xlsx');
        // }

        // return redirect()->back()->with('success', 'All contact imports have been queued.');
    }
}
