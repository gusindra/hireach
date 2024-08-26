<?php

namespace App\Http\Controllers;

use App\Exports\CellularNoExport;
use App\Exports\SkiptraceExport;
use App\Exports\WhatsappExport;
use App\Jobs\CellularUpdateValidateJob;
use App\Jobs\SkiptraceUpdateJob;
use App\Jobs\WhatsappValidateUpdateJob;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class GenerateDataController extends Controller
{
    public function view($provider)
    {
        if($provider=='datawiz'){
            //EXPORT FILE CONTACT TO DATAWIZ WITH FORMAT {TYPE}_20240820
            $filePath1 = 'SKIPTRACE_NO_'.date("Ymd").'.xlsx';
            $filePath2 = 'CELLULARNO_'.date("Ymd").'.xlsx';
            $filePath3 = 'WHATSAPP_'.date("Ymd").'.xlsx';
            // return (new InvoicesExport)->store('invoices.xlsx', 's3');
            // Excel::store(new ExportContact, $request->name . '_client.xlsx');
            Excel::store(new SkiptraceExport, $filePath1);
            Excel::store(new CellularNoExport, $filePath2);
            Excel::store(new WhatsappExport, $filePath3);
        }
    }
}
