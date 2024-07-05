<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessSmsStatus;
use App\Models\BlastMessage;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminSmsController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            // Your auth here
            $user = auth()->user();

            if ($user->super->first()) {
                if ($user->super->first()->role == 'superadmin') {
                    return $next($request);
                }
            }
            if ((auth()->user()->activeRole && str_contains(auth()->user()->activeRole->role->name, "Admin"))) {
                return $next($request);
            }
            abort(404);
        });
    }

    public function updateStatus($id, $status)
    {
        BlastMessage::find($id)->update([
            'status' => $status
        ]);
        return redirect()->back();
    }

    // show form to import file and show item
    public function formImportStatus()
    {
        return view('report.import-sms-status');
    }

    // import file & syn
    public function importStatus(Request $request)
    {
        //get file
        $upload = $request->file('csv');
        $filePath = $upload->getRealPath();
        //open and read
        $file = fopen($filePath, 'r');

        $header = fgetcsv($file);

        // dd($header);
        // $escapedHeader=[];
        //validate
        //dd($header);
        // foreach ($header as $key => $value) {
        //     // dd($key);
        //     $lheader=strtolower($value);
        //     $pieces = explode("\t", $lheader);
        //     foreach($pieces as $keyPie){
        //         $escapedItem=preg_replace('/[^a-z]/', '', $keyPie);
        //         array_push($escapedHeader, $escapedItem);
        //     }
        // }
        // dd($escapedHeader);
        $updateData = 0;
        $unpassData = 0;
        $notMatch = 0;
        $escapedData = [];

        //looping through other columns
        while ($columns = fgetcsv($file, 2048, "\t")) {
            array_push($escapedData, $columns);
        }

        foreach ($escapedData as $data) {
            if (array_key_exists("0", $data) && array_key_exists("2", $data) && array_key_exists("3", $data) && array_key_exists("6", $data)) {
                $messageid = strip_tags($data["0"]);
                $senderid = strip_tags($data["2"]);
                $msisdn = strip_tags($data["3"]);
                $status = strip_tags($data["6"]);

                $request = [
                    "msgID" => $messageid,
                    "msisdn" => $msisdn,
                    "status" => $status,
                ];
                // foreach($data as $key => $item){
                //     echo "<br>";
                //     echo $key." ".$item;
                // }
                // return $data[6];
                if ($status == "DELIVERED") {
                    $updateStatus = 'dELIVERED';
                    Log::debug($updateStatus . " - " . $status);
                } elseif ($status == "UNDELIVERED") {
                    $updateStatus = 'unDELIVERED';
                    Log::debug($updateStatus . " - " . $status);
                } else {
                    $updateStatus = 'aCCEPTED';
                    Log::debug($updateStatus . " - " . $status);
                }
                //ProcessSmsStatus::dispatch($request);
                $updateData += 1;
            } else {
                // return $data;
                //echo 1;
                //Log::debug($data);
                $notMatch += 1;
            }
        }
        // dd($escapedData);
        return view('report.import-sms-status', ["updated" => $updateData, "unpass" => $unpassData, "notmatch" => $notMatch]);
    }
}
