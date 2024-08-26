<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessSkiptrace;
use App\Jobs\ProcessValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiResourceController extends Controller
{
    public function skiptrace(Request $request)
    {
        $request->validate([
            'contact' => 'required|file|mimes:csv,xlsx,xls',
        ]);

        $path = $request->file('contact')->store('skiptrace_files');

        ProcessSkiptrace::dispatch($path, auth()->id());

        return response()->json(['message' => 'Data Import Successfully'], 200);
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

        $path = $request->file('file')->store('uploads');

        ProcessValidation::dispatch($path, $request->type, $request->user()->id);

        return response()->json(['message' => 'Data Import Successfully'], 200);
    }
}
