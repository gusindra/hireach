<?php

namespace App\Http\Controllers;

use App\Exports\CellularNoExport;
use App\Exports\SkiptraceExport;
use App\Exports\WhatsappExport;
use App\Models\Contact;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\App;

class GenerateDataController extends Controller
{
    public function view($provider)
    {
        if($provider=='datawiz'){
            //EXPORT FILE CONTACT TO DATAWIZ WITH FORMAT {TYPE}_20240820
            $filePath1 = 'In/SKIPTRACE_NO_'.date("Ymd").'.xlsx';
            $filePath2 = 'In/CELLULARNO_'.date("Ymd").'.xlsx';
            $filePath3 = 'In/WHATSAPP_'.date("Ymd").'.xlsx';
            // return (new InvoicesExport)->store('invoices.xlsx', 's3');
            // Excel::store(new ExportContact, $request->name . '_client.xlsx');
            $disk = 'local';
            if (App::environment('production')) {
                $disk = 'ftp';
            }
            // return date('Y-m-d H:i:s',strtotime("-23 hours"));;
            // return Carbon::today()->subHours(23);
            $contacts = Contact::query()
                ->selectRaw('type')
                ->selectRaw('COUNT(*) as total')
                // ->whereDate('created_at', Carbon::today())
                ->whereBetween('created_at', [date('Y-m-d H:i:s',strtotime("-23 hours")), date('Y-m-d H:i:s')])
                ->groupBy('type')
                ->get();

            foreach($contacts as $contact){
                if($contact->type == 'skip_trace' && $contact->total>0) Excel::store(new SkiptraceExport, $filePath1, $disk);
                if($contact->type == 'cellular_no' && $contact->total>0) Excel::store(new CellularNoExport, $filePath2, $disk);
                if($contact->type == 'whatsapps' && $contact->total>0) Excel::store(new WhatsappExport, $filePath3, $disk);
            }
        }
    }
}
