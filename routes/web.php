<?php

use App\Http\Controllers\AdminSmsController;
use App\Http\Controllers\ApiBulkSmsController;
use App\Http\Controllers\ApiViGuardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DevhookController;
use App\Http\Controllers\WebhookController;
use App\Http\Controllers\ApiWaController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\ChannelController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserBillingController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\CommercialController;
use App\Http\Controllers\CommissionController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FlowController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleInvitationController;
use App\Http\Controllers\TeamInvitationController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\ResourceController;
use App\Models\SaldoUser;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Http;
use App\Http\Livewire\ShowTemplate;
use App\Http\Controllers\SynProductController;
use App\Jobs\ProcessEmail;
use App\Models\ApiCredential;
use App\Models\BlastMessage;
use App\Models\Client;
use App\Models\Contract;
use App\Models\FlowSetting;
use App\Models\Notification;
use App\Models\OperatorPhoneNumber;
use App\Models\OrderProduct;
use App\Models\Template;
use App\Models\Request;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::group(['middleware' => 'web'], function () {
    // Route::get('api/documentation', '\L5Swagger\Http\Controllers\SwaggerController@api')->name('l5swagger.api');
});

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    /** ------------------------------------------
     * Admin Routes
     * --------------------------------------------
     */
    Route::prefix('admin')->middleware('admin')->group(function () {
        Route::get('/', [DashboardController::class, 'show'])->name('admin');

        //Route::get('logout', 'Backend\AuthController@logout');
        //Route::resource('change-password', 'Backend\ChangePasswordController');
        // Route::resource('users', 'Backend\UserController');

        Route::get('/user', [UserController::class, 'index'])->name('admin.user');
        Route::get('/user/{user}', [UserController::class, 'show'])->name('user.show');
        Route::get('/user/{user}/balance', [UserController::class, 'balance'])->name('user.show.balance');
        Route::get('/user/{user}/profile', [UserController::class, 'profile'])->name('user.show.profile');
        Route::get('/user/{user}/provider', [UserController::class, 'provider'])->name('user.show.provider');
        Route::get('/user/{user}/order', [UserController::class, 'profile'])->name('user.show.order');
        Route::get('/user/{user}/client', [UserController::class, 'client'])->name('user.show.client');
        Route::get('/user/{user}/client/{client}', [UserController::class, 'clientUser'])->name('client.create.user');

        // Route::get('/settings/clear-cache', 'Backend\SettingController@clearCache')->name('settings.clear-cache');
        // Route::get('/settings/rebuild-cache', 'Backend\SettingController@rebuildCache')->name('settings.rebuild-cache');
        //Route::resource('settings', 'Backend\SettingController', ['only' => ['index', 'update']]);

        Route::get('/user-billing', [UserBillingController::class, 'index'])->name('user.billing.index');
        Route::get('/user-billing/generate', [UserBillingController::class, 'generate'])->name('user.billing.generate');
        Route::post('/user-billing/invoice', [UserBillingController::class, 'invoice'])->name('user.billing.create.invoice');

        Route::get('/invoice/{billing}', [UserBillingController::class, 'showInvoice'])->name('user.billing.invoice.show');
        Route::put('/invoice/{billing}', [UserBillingController::class, 'updateInvoice'])->name('user.billing.update.invoice');

        Route::get('/roles', [RoleController::class, 'index'])->name('role.index');
        Route::get('/roles/{role}', [RoleController::class, 'show'])->name('role.show');
        Route::get('/settings/providers', [ProviderController::class, 'index'])->name('admin.settings.provider');
        Route::get('/settings/providers/{provider}', [ProviderController::class, 'show'])->name('admin.settings.provider.show');

        Route::get('/permission', function () {
            return view('permission.index', ['page' => 'permission']);
        })->name('permission.index');

        Route::get('/flow/{model}', [FlowController::class, 'show'])->name('flow.show');

        Route::get('/settings', [SettingController::class, 'index'])->name('admin.settings');

        Route::get('/settings/{page}', [SettingController::class, 'show'])->name('settings.show');

        Route::get('/order', [OrderController::class, 'index'])->name('admin.order');

        Route::get('/order/{order}', [OrderController::class, 'show'])->name('show.order');


        Route::get('/quotation', [OrderController::class, 'quotation'])->name('admin.quotation');
        Route::get('/quotation/{quotation}', [OrderController::class, 'showQuotation'])->name('show.quotation');

        Route::get('/invoice', [InvoiceController::class, 'index'])->name('admin.invoice');
        Route::get('/invoice-order/{invoice}', [InvoiceController::class, 'show'])->name('show.invoice');

        Route::get('/commission', [CommissionController::class, 'index'])->name('admin.commission');
        Route::get('/commission/{commission}', [CommissionController::class, 'show'])->name('show.commission');

        Route::get('/commercial', [CommercialController::class, 'index'])->name('commercial');
        Route::get('/commercial/{key}', [CommercialController::class, 'show'])->name('commercial.show');
        Route::get('/commercial/{key}/{id}', [CommercialController::class, 'template'])->name('invoice');

        // Route::resource('reportings', 'Backend\ReportingController');
        // Route::resource('logs', 'Backend\LogController');

        Route::get('/setting/company', [SettingController::class, 'company'])->name('settings.company');
        Route::get('setting/company/{company}', [SettingController::class, 'companyShow'])->name('settings.company.show');

        Route::get('/project', [ProjectController::class, 'index'])->name('project');
        Route::get('/project/{project}', [ProjectController::class, 'show'])->name('project.show');

        Route::get('report', [ReportController::class, 'index'])->name('admin.report');
        Route::get('report/{key}', [ReportController::class, 'show'])->name('report.show');

        Route::get('commercial/{key}/{id}', [CommercialController::class, 'edit'])->name('commercial.edit.show');
        Route::get('commercial/{id}/{type}/print', [CommercialController::class, 'template'])->name('commercial.print');
        Route::get('product/commercial/syn', [CommercialController::class, 'sync'])->name('commercial.sync');
        Route::post('product/commercial/syn', [CommercialController::class, 'syncPost'])->name('commercial.sync.post');
    });

    /** ------------------------------------------
     * User Routes
     * --------------------------------------------
     */
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Route::get('/resources', function () {
    //     return view('resource.index');
    // })->name('resources.index');
    Route::get('/resources', [ResourceController::class, 'index'])->name('resources.index');
    Route::get('/resources/create', [ResourceController::class, 'show'])->name('show.resource');

    Route::get('/contents', function () {
        return view('contents');
    })->name('contents');

    Route::get('/new', function () {
        return view('new');
    })->name('new');

    Route::get('/message', function () {
        return view('message');
    })->name('message');

    Route::get('/client', [CustomerController::class, 'index'])->name('client');

    Route::get('/template', function () {
        return view('template.index');
    })->name('template');
    Route::get('/template/helper/index', function () {
        return view('livewire.template.table-helper');
    })->name('template.helper');
    Route::get('/template/create', function () {
        return view('template.form-template');
    })->name('create.template');
    Route::get('/template/tree/view', [TemplateController::class, 'view'])->name('view.template');
    Route::get('/template/{uuid}', [TemplateController::class, 'show'])->name('show.template');
    Route::get('/template/{template}/edit', [TemplateController::class, 'edit'])->name('edit.template');

    Route::get('/billing', [BillingController::class, 'index'])->name('billing');

    Route::get('/notif-center', [NotificationController::class, 'index'])->name('notification');
    Route::get('/notif-center/{notification}', [NotificationController::class, 'show'])->name('notification.read');
    Route::get('/notif-center/read/all', [NotificationController::class, 'readAll'])->name('notification.read.all');

    Route::get('/contact/{client}', [ContactController::class, 'show'])->name('contact.show');
    Route::get('/audience', [ContactController::class, 'audience'])->name('audience.index');
    Route::get('/audience/{audience}', [ContactController::class, 'audienceShow'])->name('audience.show');

    Route::get('/channel', [ChannelController::class, 'index'])->name('channel');
    Route::get('/channel/{channel}', [ChannelController::class, 'show'])->name('channel.show');
    //Route::get('/channel/{channel}/{resource}', [ChannelController::class, 'view'])->name('channel.view');

    Route::get('/assistant',  function () {
        return view('assistant.index');
    })->name('assistant');

    Route::get('/payment/deposit', [PaymentController::class, 'index'])->name('payment.deposit');
    Route::get('/payment/topup', [PaymentController::class, 'topup'])->name('payment.topup');
    Route::get('/quotation', [PaymentController::class, 'quotation'])->name('quotation');
    Route::get('/order', function () {
        return view('assistant.invoice.index');
    })->name('user.order');
    Route::get('/order/{order}', [OrderController::class, 'showUserOrder'])->name('order.show');
    Route::get('/quotation/{quotation}', [PaymentController::class, 'quotationShow'])->name('quotation.show');

    Route::get('/payment/invoice/{id}', [PaymentController::class, 'invoice'])->name('invoice.topup');

    Route::get('/update-sms/{id}/{status}', [AdminSmsController::class, 'updateStatus'])->name('admin.update.sms.status');
    Route::get('/import/sms-status', [AdminSmsController::class, 'formImportStatus'])->name('admin.form.import.status');
    Route::post('/import/sms-status', [AdminSmsController::class, 'importStatus'])->name('admin.post.import.status');

    Route::get('/profile-user', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile');

    /** ------------------------------------------
     * Ardana Routes
     * --------------------------------------------
     */
    Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
    Route::get('/contact/create', [ContactController::class, 'create'])->name('contacts.create');
    Route::post('/contact', [ContactController::class, 'store'])->name('contacts.store');

    Route::get('/contact/exports', [ContactController::class, 'export'])->name('contact.export');
    Route::get('/contact/import', [ContactController::class, 'showFormImport'])->name('contacts.showFormImport');

    Route::post('/contact/import', [ContactController::class, 'import'])->name('contact.import');

    Route::get('/contact/{uuid}', [ContactController::class, 'edit'])->name('contacts.edit');
    Route::put('/contact/{uuid}', [ContactController::class, 'update'])->name('contacts.update');
    Route::delete('/contact/{uuid}', [ContactController::class, 'destroy'])->name('contacts.destroy');

    Route::get('/dashboard/inbound', [DashboardController::class, 'getInBound'])->name('dashboard.inbound');
    Route::get('/dashboard/outbound', [DashboardController::class, 'getOutBound'])->name('dashboard.outbound');
});

Route::get('/role-invitations/{invitation}', [RoleInvitationController::class, 'accept'])->middleware(['signed'])->name('role-invitations.accept');
Route::get('/team/invitations/{invitation}', [TeamInvitationController::class, 'accept'])->middleware(['signed'])->name('team.invitations.accept');

Route::get('/devhook', [DevhookController::class, 'index']);

Route::post('/webhook/{slug}', [ApiWaController::class, 'inbounceMessage'])->name('webhook.client');

Route::get('/endpoint', [ApiWaController::class, 'checkEndpoint'])->name('endpoint.check');


Route::get('/chat/{slug}', function ($slug) {
    return view('chat.show', ['slug' => $slug]);
});
Route::get('/chating/{slug}', [ChatController::class, 'show'])->name('chat.slug');
Route::get('/chat-me', [ChatController::class, 'chatme'])->name('chatme');
Route::get('/upload', [UploadController::class, 'index']);
Route::get('/logout', [AuthController::class, 'destroy'])->name('logout');
Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');


Route::get('cache/{id}', function ($id) {
    if ($id == "clear") {
        \Artisan::call('cache:clear');
    }
    if ($id == "view-clear") {
        \Artisan::call('view:clear');
    }
    dd("Job is done");
});


Route::get('queue/{id}', function ($id) {
    if ($id == "work") {
        \Artisan::call('queue:work --tries=3 --stop-when-empty --timeout=60');
    } elseif ($id == "restart") {
        \Artisan::call('queue:restart');
    } elseif ($id == 'json') {
        // $path = storage_path() . "/csvjson.json";
        // $path = public_path() . "/csvjson.json";
        // $content = json_decode(file_get_contents($path), true);
        // try {
        //     foreach($content as $sms){
        //         $msg_id = preg_replace('/\s+/', '', $sms['Message ID']);
        //         $msisdn = preg_replace('/\s+/', '', $sms['Send to']);
        //         $user_id = 16;
        //         // return $sms['Date/Time'];
        //         // return $sms['From'];
        //         // return $sms['Send to'];
        //         // return $sms['Message Title'];
        //         // return $sms['Message Content'];
        //         // return $sms['Message Status'];
        //         $myDate = $sms['Date/Time'];
        //         $smsDate = Carbon::createFromFormat('d/m/Y H:i', $myDate)->format('Y-m-d H:i');
        //         $client = Client::where('phone', $msisdn)->where('user_id', $user_id)->firstOr(function () use ($msisdn, $user_id) {
        //             return Client::create([
        //                 'phone' => $msisdn,
        //                 'user_id' => $user_id,
        //                 'uuid' => Str::uuid()
        //             ]);
        //         });
        //         $modelData = [
        //             'msg_id'    => $msg_id,
        //             'user_id'   => $user_id,
        //             'client_id' => $client->uuid,
        //             'sender_id' => $sms['From'],
        //             'type'      => '0',
        //             'status'    => $sms['Message Status'],
        //             'code'      => '200',
        //             'message_content'  => $sms['Message Content'],
        //             'currency'  => 'IDR',
        //             'price'     => 500,
        //             'balance'   => 0,
        //             'msisdn'    => $msisdn,
        //             'created_by'=> $date,
        //             'updated_by'=> $date,
        //         ];
        //         $blast = BlastMessage::create($modelData);

        //         $blast->created_at = $smsDate;
        //         $blast->updated_at = $smsDate;
        //         $blast->save();
        //     }
        // } catch (\Throwable $th) {
        //     dd($th);
        // }

    }
    dd("Job is done");
});

Route::get('/restart-service', function () {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $header[0] = "Authorization: whm $user:$token";
    curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
    curl_setopt($curl, CURLOPT_URL, $query);

    $result = curl_exec($curl);

    $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    if ($http_status != 200) {
        echo "[!] Error: " . $http_status . " returned\n";
    } else {
        $json = json_decode($result);
        echo "[+] Current cPanel users on the system:\n";
        echo "\t" . $result . "\n";
    }

    curl_close($curl);
    return 'success';
});

Route::get('/saveAlarm', [ApiViGuardController::class, 'index']);

//
//
// BELOW IS ROUTE FOR TESTING
// PLEASE CLEAR ALL ROUTE IN BELOW IF APP DEPOLY IN PRODUCTION SERVER
//
//
Route::get('/test', [WebhookController::class, 'index']);
Route::get('/testing', function () {
    // return 1;
    $lastError = SaldoUser::find(63);
    $errors = SaldoUser::where('balance', '<', 0)->where('user_id', '=', 1)->orderBy('id', 'asc')->get();

    foreach ($errors as $er) {
        $lastError = SaldoUser::find($er->id - 1);
        SaldoUser::find($er->id)->update([
            "balance" => $lastError->balance - $er->amount
        ]);
    }

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

});

Route::get('/tester', function (HttpRequest $request) {
    // return auth()->user()->super->first()->role;
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
            "variations" => array(array(
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
            )),
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
                    $POSTFIELDS[$post[0]] = (int)$post[1];
                } else {
                    $POSTFIELDS[$post[0]] = $post[1];
                }
                $POSTFIELDS[$post[0]] = is_numeric($post[1]) ? (int)$post[1] : $post[1];
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

    curl_setopt_array($curl, array(
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
    ));

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
    $request_host = 'https://genie-sandbox.advai.net';
    $http_method = 'POST';

    $access_key = 'd20254aee13cc156';
    $secret_key = 'b3436f168a4402b7';

    if ($request->format == 'ListMasterProduct') {
        $request_uri = '/openapi/product/master/v1/list';
        $param_json = '{"page":0,"size":2,"productName":"Test 0125001"}';
    } elseif ($request->format == 'ListInventorySku') {
        $request_uri = '/openapi/inventory/v1/sku/list';
        $param_json = '{"page":0,"size":20}';
    } elseif ($request->format == 'GetInventorySku') {
        $request_uri = '/openapi/inventory/v1/sku/get';
        $param_json = '{"inventoryId":"IN605AA65352FAFF0001A6A2F7"}';
    } else {
        $request_uri = '/openapi/shop/v1/list';
        $param_json = '{"page":0,"size":2}';
    }


    $newline = '$';
    $sign_str = $http_method . $newline . $request_uri . $newline;
    $authorization = sprintf('%s:%s', $access_key, base64_encode(hash_hmac('sha256', $sign_str, $secret_key, TRUE)));
    // echo sprintf('signature string is:%s', $sign_str . PHP_EOL);


    $header_array = array(
        'Authorization: ' . $authorization,
        'Content-Type: ' . 'application/json',
        'X-Advai-Country: ' . 'ID'
    );

    var_dump($header_array);

    $http_header = array(
        'http' => array('method' => $http_method, 'header' => $header_array, 'content' => $param_json)
    );

    $context = stream_context_create($http_header);
    return file_get_contents($request_host . $request_uri, false, $context, 0);
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
    $url = 'https://enjoymov.co/prod-api/kstbCore/sms/send';
    $md5_key = 'AFD4274C39AB55D8C8D08FA6E145D535';
    $merchantId = 'KSTB904790';
    $callbackUrl = 'http://hireach.archeeshop.com/receive-sms-status';
    $phone = '6281339668556';
    $content = 'test enjoymov api wa';

    $code = str_split($phone, 2);

    echo $code[0];
    echo "<br>";
    echo substr($phone, 2);

    $sb = $md5_key . $merchantId . $phone . $content;
    $sign = md5($sb);
    //return $sign;
    $response = Http::withOptions(['verify' => false,])->post($url, [
        'merchantId' => $merchantId,
        'sign' => $sign,
        'type' => $request['type'],
        'phone' => $request['to'],
        'countryCode' => $request['countryCode'],
        'content' => $request['text'],
        'msgChannel' => 'SM',
        "callbackUrl" => $callbackUrl,
        "msgId" => 'intenalID009'
    ]);
    return $response;
    return $request->all();
});
