<?php

namespace App\Http\Controllers;

use App\Imports\KtpImport;
use App\Jobs\ProcessSkiptrace;
use App\Jobs\ProcessValidation;
use App\Models\ClientValidation;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class ApiResourceController extends Controller
{
    public function skiptrace(Request $request)
    {
        $request->validate([
            'contact' => 'required|file|mimes:csv,xlsx,xls',
        ]);

        // Store the uploaded file
        $path = $request->file('contact')->store('skiptrace_files');

        // Dispatch the job to process the file
        ProcessSkiptrace::dispatch($path, auth()->id());

        return response()->json(['message' => 'File uploaded and processing started'], 200);
    }

    public function validation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|file|mimes:xlsx,xls,csv',
            'type' => 'required|in:cellular_no,whatsapps',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Store the uploaded file
        $path = $request->file('file')->store('uploads');

        // Dispatch the validation process job
        ProcessValidation::dispatch($path, $request->type, $request->user()->id);

        return response()->json(['message' => 'Validation started.'], 200);
    }
}
