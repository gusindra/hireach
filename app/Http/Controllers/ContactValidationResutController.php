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

        $userId = auth()->user()->id;

        if (file_exists($filePath1)) {
            SkiptraceUpdateJob::dispatch($filePath1, $userId);
        } else {
            return redirect()->back()->with('error', 'File not found: RESULT SKIPTRACE_NO_20240820.xlsx');
        }

        if (file_exists($filePath2)) {
            CellularUpdateValidateJob::dispatch($filePath2, $userId);
        } else {
            return redirect()->back()->with('error', 'File not found: RESULT CELLULARNO_20240819.xlsx');
        }

        if (file_exists($filePath3)) {
            WhatsappValidateUpdateJob::dispatch($filePath3, $userId);
        } else {
            return redirect()->back()->with('error', 'File not found: RESULT WHATSAPP_20240819.xlsx');
        }
    }
}