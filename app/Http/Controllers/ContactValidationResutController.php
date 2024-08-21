<?php

namespace App\Http\Controllers;

use App\Jobs\SkiptraceUpdateJob;
use Illuminate\Http\Request;

class ContactValidationResutController extends Controller
{
    public function importUpdateValidation(Request $request)
    {
        $filePath = storage_path('app/datawiz/RESULT SKIPTRACE_NO_20240820.xlsx');

        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File not found.');
        }

        SkiptraceUpdateJob::dispatch($filePath);
        return redirect()->back()->with('success', 'Contacts import has been queued.');
    }
}
