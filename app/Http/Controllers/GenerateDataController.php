<?php

namespace App\Http\Controllers;

use App\Exports\CellularNoExport;
use App\Exports\SkiptraceExport;
use App\Exports\WhatsappExport;
use App\Models\Contact;
use App\Models\Department;
use App\Models\Setting;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class GenerateDataController extends Controller
{
    public function view(Request $request, $provider)
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

            foreach($contacts as $key => $contact){
                if($contact->type == 'skip_trace' && $contact->total>0){
                    Excel::store(new SkiptraceExport, $filePath1, $disk);
                    //$path = storage_path($filePath1);
                    //$path = Storage::disk($disk)->path($filePath1);
                    //chmod($path, 0644);
                }
                if($contact->type == 'cellular_no' && $contact->total>0){
                    Excel::store(new CellularNoExport, $filePath2, $disk);
                    //$path = storage_path($filePath2);
                    //$path = Storage::disk($disk)->path($filePath2);
                    //chmod($path, 0644);
                }
                if($contact->type == 'whatsapps' && $contact->total>0){
                    Excel::store(new WhatsappExport, $filePath3, $disk);
                    //$path = storage_path($filePath3);
                    //$path = Storage::disk($disk)->path($filePath3);
                    //chmod($path, 0644);
                }
            }
            //Log::debug('Total contact for :'.Carbon::today().' -> '.$key+1);
            return response()->json([
                'code' => 200,
                'message' => "Successful",
                'exe_date' => Carbon::today(),
                'data'=> 'Total generate request: '.$key+1
            ]);
        }

        if($provider=='viguard'){
            if(cache('viguard_id')){
                $userId = cache('viguard_id');
            }else{
                $userId = cache()->remember('viguard_id', 6000, function (){
                    return Setting::where('key', 'viguard')->latest()->first()->value;
                });
            }
            $curl = curl_init();
            $code = 'aicsp';
            curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://218.3.11.19:8091/'.$code.'/getAllDeptList',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: eyJhbGciOiJIUzI1NiJ9.eyJqdGkiOiJmM2I4NzhlMS0wNTI4LTQ1YjQtYjM2Yy05MWU1YTkxMDk1NDYiLCJpYXQiOjE3MTY5NDgwNjYsInN1YiI6IntcIlN5c1VzZXJJZFwiOjF9IiwiZXhwIjoxNzE5NTQwMDY2fQ.kHoUPiNrQGahxX3ZeFY50p-P1nQHmPlVUve4Udy7VkE',
                'User-Agent: Apifox/1.0.0 (https://apifox.com)'
            ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            // dd($response);
            $resData = json_decode($response, true);
            if($resData && $resData['data']){
                foreach($resData['data'] as $r){
                    // return $r['deptId'];
                    if($r['parentId']=="230"){
                        Department::updateOrCreate(
                            [
                                'source_id' => $r['deptId'],
                                'user_id' => $userId
                            ],
                            [
                                'parent' => $r['parentId'],
                                'ancestors' => $r['ancestors'],
                                'name' => $r['deptName']
                            ]
                        );

                        $this->pushToLark();
                    }
                }
            }
            return response()->json([
                'msg' => "Successful sending to update depertment",
                'code' => 200
            ]);
        }
    }

    private function pushToLark(){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => env('LARK_VIGUARD'),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'User-Agent: FirmApps/1.0.0 (https://firmapps.ai)'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
    }
}
