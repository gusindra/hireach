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
use Illuminate\Support\Facades\Storage;

class GenerateDataController extends Controller
{
    /**
     * hit to generate from 3rd party
     *
     * @param  mixed $request
     * @param  mixed $provider
     * @return void
     */
    public function view(Request $request, $provider)
    {
        if($provider=='datawiz'){
            $array = [];
            //EXPORT FILE CONTACT TO DATAWIZ WITH FORMAT {TYPE}_20240820
            $filePath1 = 'In/SKIPTRACE_NO_'.date("Ymd").'.xlsx';
            $filePath2 = 'In/CELLULARNO_'.date("Ymd").'.xlsx';
            $filePath3 = 'In/WHATSAPP_'.date("Ymd").'.xlsx';
            $filePath4 = 'In/GEOLOCATION_TAG_'.date("Ymd").'.xlsx';
            $filePath5 = 'In/RECYCLING_NO_'.date("Ymd").'.xlsx';
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
            $key = 0;

            foreach($contacts as $key => $contact){
                // $path = Storage::disk($disk)->path($filePath2);
                // return Storage::url($filePath2);
                if($contact->type == 'skip_trace' && $contact->total>0){
                    Excel::store(new SkiptraceExport, $filePath1, $disk);
                    //$path = storage_path($filePath1);
                    //$path = Storage::disk($disk)->path($filePath1);
                    array_push($array, $filePath1);
                }
                if($contact->type == 'cellular_no' && $contact->total>0){
                    Excel::store(new CellularNoExport, $filePath2, $disk);
                    //$path = storage_path($filePath2);
                    //$path = Storage::disk($disk)->path($filePath2);
                    //chmod($path, 0644);
                    array_push($array, $filePath2);
                }
                if($contact->type == 'whatsapps' && $contact->total>0){
                    Excel::store(new WhatsappExport, $filePath3, $disk);
                    //$path = storage_path($filePath3);
                    //$path = Storage::disk($disk)->path($filePath3);
                    //chmod($path, 0644);
                    array_push($array, $filePath3);
                }
                if($contact->type == 'geolocation_tagging' && $contact->total>0){
                    Excel::store(new WhatsappExport, $filePath4, 'local');
                    //$path = storage_path($filePath3);
                    //$path = Storage::disk($disk)->path($filePath3);
                    //chmod($path, 0644);
                    $url = "https://hireach.firmapps.ai/storage/".$filePath4;
                    $msg = 'New file with name '.$filePath4.' was created for service '.$contact->type.', please proccess this client request manually to Atlasat. Link: '.$url;
                    //$text = '{"msg_type": "post","content": {"en_us": {"title": "Manual Request file '.$contact->type.'","content": [[{"tag": "text","text": "'.$msg.'"},{"tag": "a","text": "'.$filePath4.'","href": "'.$url .'"},{"tag": "at","user_id": "all","user_name": "Everyone"}]]}}}';
                    array_push($array, $filePath4);
                    $this->pushToLark('datawiz', $msg);
                }
                if($contact->type == 'recycle_status' && $contact->total>0){
                    Excel::store(new WhatsappExport, $filePath5, 'local');
                    //$path = storage_path($filePath3);
                    //$path = Storage::disk($disk)->path($filePath3);
                    //chmod($path, 0644);
                    //hireach.firmapps.ai/storage/In/RESULT CELLULARNO_20240926.xlsx
                    $url = "https://hireach.firmapps.ai/storage/".$filePath5;
                    $msg = 'New file with name '.$filePath5.' was created for service '.$contact->type.', please proccess this client request manually to Atlasat. Link: '.$url;
                    //$text = '{"msg_type": "post","content": {"en_us": {"title": "Manual Request file '.$contact->type.'","content": [[{"tag": "text","text": "'.$msg.'"},{"tag": "a","text": "'.$filePath4.'","href": "'.$url .'"},{"tag": "at","user_id": "all","user_name": "Everyone"}]]}}}';

                    array_push($array, $filePath5);
                    $this->pushToLark('datawiz', $msg);
                }
            }
            //Log::debug('Total contact for :'.Carbon::today().' -> '.$key+1);

            return response()->json([
                'code' => 200,
                'message' => "Successful",
                'exe_date' => Carbon::today(),
                'data'=> $array
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
                        $msg = 'New department with name '.$r['deptName'].' was createed, please make update to add contact for this department.';
                        //$text = '{"msg_type":"text","content":{"text":"<at user_id="all">everyone</at>'.$msg.'"}}';
                        $this->pushToLark('viguard', $msg);
                    }
                }
            }
            return response()->json([
                'msg' => "Successful sending to update depertment",
                'code' => 200
            ]);
        }
    }

    /**
     * pushToLark
     *
     * @param  mixed $source
     * @return void
     */
    private function pushToLark($source, $text){
        $url = env('LARK_VIGUARD');
        if($source=='datawiz'){
            $url = env('LARK_DATAWIZ');
        }
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
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
            CURLOPT_POSTFIELDS => '{"msg_type":"text","content":{"text":"'.$text.'"}}',
        ));

        $response = curl_exec($curl);
        Log::debug($response);
        curl_close($curl);
    }
}
