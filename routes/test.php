<?php

use App\Http\Controllers\ApiBulkSmsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebhookController;
use App\Http\Controllers\TeamInvitationController;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;

/*
|--------------------------------------------------------------------------
| TESTING Routes
|--------------------------------------------------------------------------
|
| PLEASE CLEAR ALL ROUTE IN BELOW IF APP DEPOLY IN PRODUCTION SERVER
|
*/

Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
});

Route::get('/test', [WebhookController::class, 'index']);

Route::get('/testing', function (HttpRequest $request) {
    $queue = \Illuminate\Support\Facades\DB::table(config('queue.connections.database.table'))->where('payload', 'like', '%ProcessValidation%')->get();
    foreach($queue as $q){
        $payload = json_decode($q->payload,true);
        $payload1 = $payload['data']['command'];
        $getId = explode('userId',$payload1);
        if(strpos($getId[1], auth()->user()->id) !== false) return 'loading';
    }
    return 1;
    // $file_path = 'product/'.str_random(30).time().'.jpg';
    // Storage::disk('spaces')->put($file_path, base64_decode($image), 'public');
    // return Storage::disk('spaces')->url($file_path);
    //return base64_decode($image);
    // $name = date('YmdHis').'.png';
    // $path = 'images/'.date('Y').'/'.date('F').'/'.$name;

    // // $this->photo->storeAs('photos', $name);
    // $file = Storage::disk('s3')->put($path, base64_decode($image), 'public');
    // return Storage::disk('s3')->url($path);

    // if($request->disk=='ftp'){
    //     return $files = Storage::disk('ftp')->allFiles('/');
    // }elseif($request->disk=='sftp'){
    //     return $files = Storage::disk('sftp')->allFiles('/');
    // }else{
    //     return $files = Storage::allFiles('/');
    // }
    // return 1;
    // $gates = app(Gate::class)->abilities();
    // // echo implode("\n", array_keys($gates));
    // dd($gates);
    // $user = auth()->user();

    // if ($user->isNoAdmin && $user->isNoAdmin->role === "agen") {
    //     $currentRoute = request()->route()->getName();
    //     dd($currentRoute = request()->route()->getName() === 'messagea');
    //     return $currentRoute === 'message'; // Periksa apakah route saat ini adalah 'messages'
    // }'
    // $count = 0;
    // $c = Campaign::find(2);
    // $currentTime = Carbon::now(); // SET GMT di config
    // $scheduleNow = explode(':', $currentTime);
    // //return $scheduleNow[0];
    // foreach ($c->schedule as $s) {
    //     // echo $s;
    //     //CHECK MONTH
    //     if ($c->shedule_type == 'yearly') {
    //         $pass = false;
    //         if ($s->month == $currentTime->format('m')) {
    //             if ($s->day == $currentTime->format('l')) {
    //                 $pass = true;
    //             } elseif ($s->day == $currentTime->format('j')) {
    //                 $pass = true;
    //             }
    //         }
    //     }
    //     //CHECK DAY
    //     if ($c->shedule_type == 'monhly') {
    //         $pass = false;
    //         if ($s->day == $currentTime->format('l')) {
    //             $pass = true;
    //             echo 'll';
    //         } elseif ($s->day == $currentTime->format('j')) {
    //             $pass = true;
    //             echo 'jj';
    //         }
    //     }
    //     //CHECK TIME
    //     //CHECK DAY
    //     if ($c->shedule_type == 'daily') {
    //         $pass = true;
    //     }
    //     if ($pass) {
    //         $scheduleDb = explode(':', $s->time);
    //         $scheduleNow = explode(':', $currentTime->format('H:i'));
    //         if ($s->status == 0 && $scheduleDb[0] >= $scheduleNow[0]) {
    //             $count = $count + 1;
    //             if ($c->provider == 'provider3') {
    //                 echo $s;
    //             } else {
    //                 echo $s;
    //             }
    //         }
    //     }
    // }
    // return $count;
    // if(($campaign && ($campaign->to != '' || $campaign->audience_id))){
    //     $contact = $campaign->to != '' && !str_contains( $campaign->to, 'Audience') ? explode(',', $campaign->to) : $campaign->audience->audienceClients;
    //     $data = [
    //         'type' => $campaign->type,
    //         'from' => $campaign->from,
    //         'text' => $campaign->text,
    //         'title' => $campaign->title,
    //         'otp' => $campaign->otp,
    //         'provider' => $campaign->provider,
    //     ];

    //     if($campaign->template_id!=NULL){
    //         $data['templateid'] = $campaign->template_id;
    //     }
    //     foreach ($contact as $c) {
    //         return $data['to'] = $c->client->email;

    //         $user = $campaign->user;

    //         return $data;
    //     }
    // }else{
    //     return 0;
    // }


    // return 1;
    // $lastError = SaldoUser::find(63);
    // $errors = SaldoUser::where('balance', '<', 0)->where('user_id', '=', 1)->orderBy('id', 'asc')->get();

    // foreach ($errors as $er) {
    //     $lastError = SaldoUser::find($er->id - 1);
    //     SaldoUser::find($er->id)->update([
    //         "balance" => $lastError->balance - $er->amount
    //     ]);
    // }

    return "done";
    // $phoneNo = '6281339668556';
    // $phoneNo = substr($phoneNo, 0, 5);
    // return OperatorPhoneNumber::where('code', $phoneNo)->first();

    // return storage_path();
    // \Log::channel('apilog')->info('Data SMS is');
    // $contract = Contract::find(10);
    // return $contract->attachments->sortByDesc('id')->first();
    // return base64_encode('SITC01'.':'.'92f70cad-1fa4-40de-bbd8-39dbfd6a7242');
    // $request = Request::find(244);
    // return $request->client->team->detail;
    // return $userCredention->team->detail;

    // $curl = curl_init();

    // curl_setopt_array($curl, array(
    //     CURLOPT_URL => 'http://pickup.sicepat.com:8087/api/partner/requestpickuppackage',
    //     CURLOPT_RETURNTRANSFER => true,
    //     CURLOPT_ENCODING => '',
    //     CURLOPT_MAXREDIRS => 10,
    //     CURLOPT_TIMEOUT => 0,
    //     CURLOPT_FOLLOWLOCATION => true,
    //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //     CURLOPT_CUSTOMREQUEST => 'POST',
    //     CURLOPT_POSTFIELDS =>'{
    //         "auth_key": "C70575F6ADB1457DBBB0AE825FC04542",
    //         "reference_number": "SICEPAT-TEST-SCPT123",
    //         "pickup_request_date": "2021-01-01 09:00",
    //         "pickup_merchant_name": "Telixmart",
    //         "pickup_method": "PICKUP",
    //         "pickup_address": "Jalan Daan Mogot II No. 100, M-NN No.RT.6, RT.6/RW.5, Duri Kepa, Kec. Kb. Jeruk, Kota Jakarta Barat, Daerah Khusus Ibukota Jakarta 11510",
    //         "pickup_city": "KOTA JAKARTA BARAT",
    //         "pickup_merchant_phone": "02150200050",
    //         "pickup_merchant_email": "support@jarvis-store.com",
    //         "PackageList": [
    //             {
    //                 "receipt_number": "999888777111",
    //                 "origin_code": "CGK",
    //                 "delivery_type": "BEST",
    //                 "parcel_category": "Clothing",
    //                 "parcel_content": "Kaos Katun Polos",
    //                 "parcel_qty": 2,
    //                 "parcel_uom": "Pcs",
    //                 "parcel_value": 199000,
    //                 "total_weight": 0.6,
    //                 "shipper_name": "Sicepat Telixmart",
    //                 "shipper_address": "Jalan Daan Mogot II No. 100, M-NN No.RT.6, RT.6/RW.5, Duri Kepa, Kec. Kb. Jeruk, Kota Jakarta Barat, Daerah Khusus Ibukota Jakarta 1510",
    //                 "shipper_province": "DKI JAKARTA",
    //                 "shipper_city": "KOTA JAKARTA BARAT",
    //                 "shipper_district": "KEBON JERUK",
    //                 "shipper_zip": "11510",
    //                 "shipper_phone": "02150200050",
    //                 "shipper_longitude": "-6.155960",
    //                 "shipper_latitude": "106.708860",
    //                 "recipient_title": "Mrs",
    //                 "recipient_name": "Ratna Galih",
    //                 "recipient_address": "testing tanpa lang & lat recipient",
    //                 "recipient_province": "JAWA TENGAH",
    //                 "recipient_city": "KAB. BANYUMAS",
    //                 "recipient_district": "PURWOKERTO BARAT",
    //                 "recipient_zip": "53132",
    //                 "recipient_phone": "087888888888",
    //                 "destination_code": "SRG10424"
    //             }
    //         ]
    //     }',
    //     CURLOPT_HTTPHEADER => array(
    //         'Content-Type: application/json'
    //     ),
    // ));

    // $response = curl_exec($curl);

    // curl_close($curl);
    // echo $response;

})->name('messagea');

Route::get('/tester', function (HttpRequest $request) {
    return auth()->user()->super->first()->role;
    // $sms = BlastMessage::find(435);
    // if($quote = App\Models\Quotation::where('client_id', 1)->whereIn('status', ['reviewed'])->orderBy('id', 'desc')->first()){
    //     $items = OrderProduct::orderBy('id', 'asc')->where('model', 'Quotation')->where('model_id', $quote->id)->get();
    //     foreach($items as $product){
    //         echo $product;
    //         if(Str::contains($product->name, 'SMS NON OTP') && $sms->otp == 0){
    //             return $product->price.' NONOTP '.$sms->id;
    //         }elseif(Str::contains($product->name, 'SMS OTP') && $sms->otp == 1){
    //             return $product->price.' OTP '.$sms->id;
    //         }
    //     }
    // }
    // return 0;
    // return $request;
    $url = $request->url ?? '';
    $secretkey = $request->key;
    $accesskey = 'd20254aee13cc156';
    $POSTFIELDS = array();

    $varian = array(
        "averageCostPrice" => array(
            "amount" => 0,
            "currencyCode" => "IDR"
        ),
        "boundVariationCount" => 0,
        "images" => [],
        "optionValues" => ["-"],
        "sellingPrice" => array(
            "amount" => 10,
            "currencyCode" => "IDR"
        ),
        "sku" => "0125001-001",
        "status" => "ACTIVE",
        "stock" => array(
            "availableStock" => 10,
            "safetyAlert" => false,
            "safetyStock" => 0
        ),
        "bundleVariations" => array(
            array(
                "quantity" => 1,
                "bundleVariationId" => "MV111100000222220"
            )
        ),
        "type" => "BUNDLE"
    );

    if ($request->format == 'add_product') {
        $POSTFIELDS = array(
            'id' => null,
            'brand' => "",
            'type' => "NORMAL",
            'variantOptions' => [],
            'name' => "Test Produk Lagi",
            'saleStatus' => "FOR_SALE",
            'condition' => "NEW",
            'minPurchase' => 10,
            'shortDescription' => "Test Produk Lagi",
            'description' => "Test HTMl Produk Lagi",
            "variations" => array(
                array(
                    "sellingPrice" => array(
                        "amount" => 20000,
                        "currencyCode" => "IDR"
                    ),
                    "sku" => "2022007-001",
                    "stock" => array(
                        "availableStock" => 10,
                        "safetyAlert" => false,
                        "safetyStock" => 0
                    ),
                    "status" => "ACTIVE",
                    "type" => "NORMAL",
                    "purchasePrice" => array(
                        "amount" => 20000,
                        "currencyCode" => "IDR"
                    ),
                )
            ),
            "images" => [],
            "status" => "PENDING_REVIEW"

        );
        // $POSTFIELDS = '{
        //     "id": null,
        //     "brand": "",
        //     "type": "BUNDLE",
        //     "variantOptions": [],
        //     "name": "Test 0125001",
        //     "fullCategoryId": ["100534", "100577"],
        //     "saleStatus": "FOR_SALE",
        //     "condition": "NEW",
        //     "minPurchase": 10,
        //     "shortDescription": "Test",
        //     "description": "<p>Test</p>",
        //     "extraInfo": {
        //         "preOrder": {
        //             "settingType": "PRODUCT_OFF",
        //             "timeUnit": "DAY"
        //         }
        //     },
        //     "variations": [{
        //         "averageCostPrice": {
        //             "amount": 0,
        //             "currencyCode": "IDR"
        //         },
        //         "boundVariationCount": 0,
        //         "images": [],
        //         "optionValues": ["-"],
        //         "sellingPrice": {
        //             "amount": 10,
        //             "currencyCode": "IDR"
        //         },
        //         "sku": "0125001-001",
        //         "status": "ACTIVE",
        //         "stock": {
        //             "availableStock": 10,
        //             "safetyAlert": false,
        //             "safetyStock": 0
        //         },
        //         "bundleVariations": [{
        //                 "quantity": 1,
        //                 "bundleVariationId": "MV111100000222220"
        //         }],
        //         "type": "BUNDLE"
        //     }],
        //     "images": [],
        //     "delivery": {
        //         "lengthUnit": "cm",
        //         "weightUnit": "g"
        //     },
        //     "costInfo": {
        //         "purchasingTimeUnit": "HOUR",
        //         "salesTax": {
        //             "currencyCode": "IDR"
        //         }
        //     },
        //     "status": "PENDING_REVIEW"
        // }';
        $POSTFIELDS = json_encode($POSTFIELDS);
    } elseif ($request->format == 'show_variation') {
        $url = '/openapi/product/variation/v1/list-price';
        $POSTFIELDS = array(
            'masterVariationIds' => array("MV62C51CC789701100017EA5A6"),
            'page' => 0,
            'size' => 5
        );
        $POSTFIELDS = json_encode($POSTFIELDS);
    } elseif ($request->format == 'list_product') {
        $url = '/openapi/product/master/v1/list';
        $POSTFIELDS = array(
            'page' => 0,
            'size' => 5
        );
        $POSTFIELDS = json_encode($POSTFIELDS);
    } elseif ($request->format == 'list_shop') {
        $url = '/openapi/shop/v1/list';
        $POSTFIELDS = array(
            'page' => 0,
            'size' => 100
        );
        $POSTFIELDS = json_encode($POSTFIELDS);
    } elseif ($request->format == 'list_categories') {
        $url = '/openapi/shop/v1/categories/list';
        $POSTFIELDS = json_encode($POSTFIELDS);
    } else {
        if ($request->has('post')) {
            foreach (explode(",", $request->post) as $key => $posts) {
                $post = explode(":", $posts);
                if (is_numeric($post[1])) {
                    $POSTFIELDS[$post[0]] = (int) $post[1];
                } else {
                    $POSTFIELDS[$post[0]] = $post[1];
                }
                $POSTFIELDS[$post[0]] = is_numeric($post[1]) ? (int) $post[1] : $post[1];
            }
        }
        $POSTFIELDS = json_encode($POSTFIELDS);
    }

    $sign_ginee = Http::get('http://jarvis1.pythonanywhere.com/welcome/default/signature_genie?url=' . $url . '&key=' . $secretkey);
    $signature = $sign_ginee['signature'];
    $signature = $accesskey . ':' . $sign_ginee['signature'];

    $ginee_url = 'https://genie-sandbox.advai.net';
    $method = $request->has('method') ? $request->method : 'GET';

    // echo $hash =  hash_hmac('sha256', 'abcde', 'abc');
    // return $user = Client::where('phone', 1234543)->where('user_id', 4)->firstOr(function () {
    //     return Client::create([
    //         'phone' => 1234543,
    //         'user_id' => 4,
    //         'uuid' => Str::uuid()
    //     ]);
    // });

    // $client = Client::firstOrNew(
    //     ['phone' =>  1234543],
    //     ['user_id' => 4]
    // );
    // $client->save();
    // return $client;

    $headers = array(
        'X-Advai-Country: ID',
        'Authorization: ' . $signature,
        'Content-Type: application/json'
    );

    $curl = curl_init();

    curl_setopt_array(
        $curl,
        array(
            CURLOPT_URL => $ginee_url . $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => $POSTFIELDS,
            CURLOPT_HTTPHEADER => $headers,
        )
    );

    $response = curl_exec($curl);

    curl_close($curl);
    //MAKE CURL
    echo 'curl -X ' . $method . ' \<br>';
    foreach ($headers as $k => $head) {
        echo '-H ' . $head . ' \<br>';
    }
    echo '-d ' . $POSTFIELDS . ' \<br>';
    echo '"' . $ginee_url . $url . '" <br>';
    //END CURL
    echo '<br><br>';
    echo $signature . '<br>';
    // echo $url.'<br><br>';
    echo $response;

    // curl_setopt($ch, CURLOPT_URL, 'https://genie-sandbox.advai.net/openapi/shop/v1/list');
    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    // curl_setopt($ch, CURLOPT_POST, 1);
    // curl_setopt($ch, CURLOPT_POSTFIELDS, "{\n    \"page\":0,\n    \"size\":10,\n}");

    // $headers = array();
    // $headers[] = 'X-Advai-Country: ID';
    // $headers[] = 'Authorization: b3436f168a4402b7:VHlSfqFIY3gCMKWO6BKkmn7VmBKPF+KUCk/9o+gbURE=';
    // $headers[] = 'Content-Type: application/json';
    // curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    // Generated @ codebeautify.org

    // curl_setopt($ch, CURLOPT_URL, 'https://genie-sandbox.advai.net/openapi/shop/v1/categories/list');
    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    // curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');


    // $headers = array();
    // $headers[] = 'X-Advai-Country: ID';
    // $headers[] = 'Authorization: b3436f168a4402b7:zOuRJ7s/pbNPl8AjCe7R2Wm2+uBIHPKxEak1LrXQTHI=';
    // curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);



    // echo $result = curl_exec($ch);
    // if (curl_errno($ch)) {
    //     echo 'Error:' . curl_error($ch);
    // }
    // curl_close($ch);
});

Route::get('test1', function (HttpRequest $request) {
    // $request_host = 'https://api.ginee.com';
    // $request_host = 'https://genie-sandbox.advai.net';
    // $http_method = 'POST';

    // $access_key = 'd20254aee13cc156';
    // $secret_key = 'b3436f168a4402b7';

    // if ($request->format == 'ListMasterProduct') {
    //     $request_uri = '/openapi/product/master/v1/list';
    //     $param_json = '{"page":0,"size":2,"productName":"Test 0125001"}';
    // } elseif ($request->format == 'ListInventorySku') {
    //     $request_uri = '/openapi/inventory/v1/sku/list';
    //     $param_json = '{"page":0,"size":20}';
    // } elseif ($request->format == 'GetInventorySku') {
    //     $request_uri = '/openapi/inventory/v1/sku/get';
    //     $param_json = '{"inventoryId":"IN605AA65352FAFF0001A6A2F7"}';
    // } else {
    //     $request_uri = '/openapi/shop/v1/list';
    //     $param_json = '{"page":0,"size":2}';
    // }


    // $newline = '$';
    // $sign_str = $http_method . $newline . $request_uri . $newline;
    // $authorization = sprintf('%s:%s', $access_key, base64_encode(hash_hmac('sha256', $sign_str, $secret_key, TRUE)));
    // // echo sprintf('signature string is:%s', $sign_str . PHP_EOL);


    // $header_array = array(
    //     'Authorization: ' . $authorization,
    //     'Content-Type: ' . 'application/json',
    //     'X-Advai-Country: ' . 'ID'
    // );

    // var_dump($header_array);

    // $http_header = array(
    //     'http' => array('method' => $http_method, 'header' => $header_array, 'content' => $param_json)
    // );

    // $context = stream_context_create($http_header);
    // return file_get_contents($request_host . $request_uri, false, $context, 0);
});

Route::get('/email', function () {
    // $request = SaldoUser::create([
    //     'currency'      => 'idr',
    //     'amount'        => 100,
    //     'mutation'      => 'credit',
    //     'description'   => 'TEST Pemotongan sms / delete notif',
    //     'user_id'       => '18'
    // ]);
    // $notif = 0;
    // // if($request->mutation == 'debit'){
    // //     $notif_count = Notification::where('model', 'Balance')->where('user_id', $request->user_id)->count();
    // //     if(($notif_count==1 && $request->balance <= 50000) || ($notif_count==0 && $request->balance <= 100000)){
    // //         $notif = Notification::create([
    // //             'type'          => 'email',
    // //             'model_id'      => $request->id,
    // //             'model'         => 'Balance',
    // //             'notification'  => 'Balance Alert. Your current balance remaining Rp'.number_format($request->balance) ,
    // //             'user_id'       => $request->user_id,
    // //             'status'        => 'unread',
    // //         ]);

    // //         if($notif){
    // //             ProcessEmail::dispatch($request, 'alert_balance');
    // //         }
    // //     }
    // // }

    // if($request->mutation == 'credit'){
    //     $notif = Notification::where('type', 'email')->where('model', 'Balance')->where('user_id', $request->user_id)->delete();
    // }

    //dd($notif, $request);

    // return $notif;
    // Mail::raw('Text to e-mail', function($message)
    // {
    //     $message->from('saritune@gmail.com', 'Laravel');
    //     $message->to('gusin44@yahoo.com');
    // });
});

// Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//     return view('dashboard');
// })->name('dashboard');
// Route::middleware(['auth:sanctum', 'verified'])->get('/client', function () {
//     return view('client');
// })->name('client');
// Route::middleware(['auth:sanctum', 'verified'])->get('/message', function () {
//     return view('message');
// })->name('message');
// Route::middleware(['auth:sanctum', 'verified'])->get('/template', function () {
//     return view('template');
// })->name('template');
// Route::middleware(['auth:sanctum', 'verified'])->get('/billing', function () {
//     return view('billing');
// })->name('billing');

//retrive json and save to db
// Route::get('/get-from-ginee', [SynProductController::class, 'index']);

// testing response json format\
Route::get('/json', [ApiBulkSmsController::class, 'ginee']);

Route::get('/joymove', function (HttpRequest $request) {
    // $url = 'https://enjoymov.co/prod-api/kstbCore/sms/send';
    // $md5_key = 'AFD4274C39AB55D8C8D08FA6E145D535';
    // $merchantId = 'KSTB904790';
    // $callbackUrl = 'http://hireach.archeeshop.com/receive-sms-status';
    // $phone = '6281339668556';
    // $content = 'test enjoymov api wa';

    // $code = str_split($phone, 2);

    // echo $code[0];
    // echo "<br>";
    // echo substr($phone, 2);

    // $sb = $md5_key . $merchantId . $phone . $content;
    // $sign = md5($sb);
    // //return $sign;
    // $response = Http::withOptions(['verify' => false,])->post($url, [
    //     'merchantId' => $merchantId,
    //     'sign' => $sign,
    //     'type' => $request['type'],
    //     'phone' => $request['to'],
    //     'countryCode' => $request['countryCode'],
    //     'content' => $request['text'],
    //     'msgChannel' => 'SM',
    //     "callbackUrl" => $callbackUrl,
    //     "msgId" => 'intenalID009'
    // ]);
    // return $response;
    // return $request->all();
});


$authMiddleware = config('jetstream.guard')
    ? 'auth:' . config('jetstream.guard')
    : 'auth';

$authSessionMiddleware = config('jetstream.auth_session', false)
    ? config('jetstream.auth_session')
    : null;

Route::group(['middleware' => 'web'], function () {
    // Teams...

    Route::get('/team-invitations/{invitation}', [TeamInvitationController::class, 'accept'])
        ->middleware(['signed'])
        ->name('team-invitations.accept');
    // Route::get('/team-invitations/{invitation}', function () {
    //     return 1;
    // });
});

