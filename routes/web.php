<?php

use App\Http\Controllers\AdminSmsController;
use App\Http\Controllers\ApiBulkSmsController;
use App\Http\Controllers\ApiViGuardController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\UserOrderController;
use App\Http\Controllers\UserQuotationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DevhookController;
use App\Http\Controllers\WebhookController;
use App\Http\Controllers\ApiWaController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\CampaignController;
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
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\UserChatController;
use App\Models\Attachment;
use App\Models\Campaign;
use Carbon\Carbon;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

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
        Route::get('/dashboard/active-user', [DashboardController::class, 'activeUser'])->name('dashboard.active.user');
        Route::get('/dashboard/order', [DashboardController::class, 'orderSummary'])->name('dashboard.order');
        Route::get('/dashboard/provider', [DashboardController::class, 'providerSummary'])->name('dashboard.provider');
        //Route::get('logout', 'Backend\AuthController@logout');
        //Route::resource('change-password', 'Backend\ChangePasswordController');
        // Route::resource('users', 'Backend\UserController');

        Route::get('/user', [UserController::class, 'index'])->name('admin.user');
        Route::get('/user/{user}', [UserController::class, 'show'])->name('user.show');
        Route::get('/user/{user}/balance', [UserController::class, 'balance'])->name('user.show.balance');
        Route::get('/user/{user}/profile', [UserController::class, 'profile'])->name('user.show.profile');
        Route::get('/user/{user}/provider', [UserController::class, 'provider'])->name('user.show.provider');
        Route::get('/user/{user}/order', [UserController::class, 'order'])->name('user.show.order');
        Route::get('/user/{user}/client', [UserController::class, 'client'])->name('user.show.client');
        Route::get('/user/{user}/client/{client}', [UserController::class, 'clientUser'])->name('client.create.user');
        Route::get('/user/{user}/request', [UserController::class, 'request'])->name('user.show.request');

        Route::get('/department', [UserController::class, 'listDepartment'])->name('admin.department');
        Route::get('/get/api/department', [UserController::class, 'getDepartment'])->name('admin.department.get');

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

        Route::get('/settings', [SettingController::class, 'index'])->name('admin.settings');
        Route::get('/settings/providers', [ProviderController::class, 'index'])->name('admin.settings.provider');
        Route::get('/settings/{page}', [SettingController::class, 'show'])->name('settings.show');
        Route::get('/setting/log', [SettingController::class, 'logChange'])->name('settings.logChange');
        Route::get('/setting/log/export', [SettingController::class, 'logExport'])->name('settings.log.export');
        Route::get('/settings/providers/{provider}', [ProviderController::class, 'show'])->name('admin.settings.provider.show');
        Route::get('setting/product-line/{productLine}', [SettingController::class, 'productLineShow'])->name('settings.productLine.show');
        Route::get('setting/commerce-item/{commerceItem}', [SettingController::class, 'commerceItemShow'])->name('settings.commerceItem.show');

        Route::get('/permission', [PermissionController::class, 'index'])->name('permission.index');
        Route::get('/setting/company', [SettingController::class, 'company'])->name('settings.company');
        Route::get('setting/company/{company}', [SettingController::class, 'companyShow'])->name('settings.company.show');

        Route::get('/flow/{model}', [FlowController::class, 'show'])->name('flow.show');

        Route::get('/order', [OrderController::class, 'index'])->name('admin.order');
        Route::get('/order/{order}', [OrderController::class, 'show'])->name('show.order');

        Route::get('/quotation', [OrderController::class, 'quotation'])->name('admin.quotation');
        Route::get('/quotation/{quotation}', [OrderController::class, 'showQuotation'])->name('show.quotation');

        Route::get('/invoice', [InvoiceController::class, 'index'])->name('admin.invoice');
        Route::get('/invoice-order/{invoice}', [InvoiceController::class, 'show'])->name('show.invoice');

        Route::get('/commission', [CommissionController::class, 'index'])->name('admin.commission');
        Route::get('/commission/{commission}', [CommissionController::class, 'show'])->name('show.commission');

        // Route::resource('reportings', 'Backend\ReportingController');
        // Route::resource('logs', 'Backend\LogController');

        Route::get('/project', [ProjectController::class, 'index'])->name('project');
        Route::get('/project/{project}', [ProjectController::class, 'show'])->name('project.show');

        Route::get('report', [ReportController::class, 'index'])->name('admin.report');
        Route::get('report/{key}', [ReportController::class, 'show'])->name('report.show');

        Route::get('/commercial', [CommercialController::class, 'index'])->name('commercial');
        Route::get('/commercial/{key}', [CommercialController::class, 'show'])->name('commercial.show');
        Route::get('/commercial/{key}/{id}', [CommercialController::class, 'template'])->name('invoice');
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

    Route::get('/campaign', [CampaignController::class, 'index'])->name('campaign.index');
    Route::get('/campaign/{campaign}', [CampaignController::class, 'show'])->name('campaign.show');

    Route::get('/resources', [ResourceController::class, 'index'])->name('resources.index');
    Route::get('/resources/create', [ResourceController::class, 'show'])->name('show.resource');

    Route::get('/contents', function () {
        return view('contents');
    })->name('contents');

    Route::get('/new', function () {
        return view('new');
    })->name('new');

    Route::get('/message', [UserChatController::class, 'index'])->name('message');
    Route::get('/client', [CustomerController::class, 'index'])->name('client');

    Route::get('/template', [TemplateController::class, 'index'])->name('template');
    Route::get('/template/helper/index', [TemplateController::class, 'templateHelper'])->name('template.helper');
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

    Route::get('/assistant', function () {
        return view('assistant.index');
    })->name('assistant');

    Route::get('/payment/deposit', [PaymentController::class, 'index'])->name('payment.deposit');
    Route::get('/payment/topup', [PaymentController::class, 'topup'])->name('payment.topup');
    Route::get('/quotation', [UserQuotationController::class, 'quotation'])->name('quotation');
    Route::get('/quotation/{quotation}', [UserQuotationController::class, 'quotationShow'])->name('quotation.show');
    Route::get('/order', [UserOrderController::class, 'orderUSer'])->name('user.order');
    Route::get('/order/{order}', [UserOrderController::class, 'showUserOrder'])->name('order.show');

    Route::get('/payment/invoice/{id}', [PaymentController::class, 'invoice'])->name('invoice.topup');

    Route::get('/update-sms/{id}/{status}', [AdminSmsController::class, 'updateStatus'])->name('admin.update.sms.status');
    Route::get('/import/sms-status', [AdminSmsController::class, 'formImportStatus'])->name('admin.form.import.status');
    Route::post('/import/sms-status', [AdminSmsController::class, 'importStatus'])->name('admin.post.import.status');

    Route::get('/profile-user', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile');

    Route::get('/teams', function () {
        return view('teams.index');
    })->name('teams');

    /** ------------------------------------------
     * Ardana Routes
     * --------------------------------------------
     */
    Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
    Route::get('/contact/create', [ContactController::class, 'create'])->name('contacts.create');
    Route::post('/contact', [ContactController::class, 'store'])->name('contacts.store');

    Route::get('/contact/request/exports', [ContactController::class, 'export'])->name('contact.export');
    Route::get('/contact/request/import', [ContactController::class, 'showFormImport'])->name('contacts.showFormImport');

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
// ==================================
// CRON JOB URL
// ==================================
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

Route::get('campaign-schedule', [ScheduleController::class, 'index'])->name('schedule.start');
Route::get('campaign-schedule-reset', [ScheduleController::class, 'reset'])->name('schedule.reset');
// ==================================
// END CRON JOB URL
// // ==================================
// Route::get('/saveAlarm', [ApiViGuardController::class, 'index']);
Route::post('/saveAlarm', [ApiViGuardController::class, 'post']);
Route::post('/getAllMonitoringDeviceList', [ApiViGuardController::class, 'getMonitoringDevice']);
Route::post('/getAllDeptList', [ApiViGuardController::class, 'getDeptList']);

//
//
// BELOW IS ROUTE FOR TESTING
// PLEASE CLEAR ALL ROUTE IN BELOW IF APP DEPOLY IN PRODUCTION SERVER
//
//
Route::get('/test', [WebhookController::class, 'index']);

Route::get('/testing', function (HttpRequest $request) {
    $img = "data:image/png;base64, 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";
    $image = explode(',', $img);
    $ext = explode('/', $image[0]);
    $extension = explode(';', $ext[1]);
    // return '<img src="'.$image.'" />';
    $data = base64_decode($image[1]);

    $im = imagecreatefromstring($data);
    if ($im !== false) {
        imagedestroy($im);
        Storage::put(date('YmdHis').$extension[0], $data);
        // Storage::put('file.png', base64_decode($image));
        $url = Storage::url(date('YmdHis').$extension[0]);
        Attachment::create([
            'model_id'      => $request->id,
            'model'         => 'BlastMessage',
            'uploaded_by'   => 'viguard',
            'file'          => $url
        ]);;
    }
    else {
        return 'An error occurred.';
    }
    // $file_path = 'product/'.str_random(30).time().'.jpg';
    // Storage::disk('spaces')->put($file_path, base64_decode($image), 'public');
    // return Storage::disk('spaces')->url($file_path);
    //return base64_decode($image);
    $name = date('YmdHis').'.png';
    $path = 'images/'.date('Y').'/'.date('F').'/'.$name;

    // $this->photo->storeAs('photos', $name);
    $file = Storage::disk('s3')->put($path, base64_decode($image), 'public');
    return Storage::disk('s3')->url($path);

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
    $count = 0;
    $c = Campaign::find(2);
    $currentTime = Carbon::now(); // SET GMT di config
    $scheduleNow = explode(':', $currentTime);
    //return $scheduleNow[0];
    foreach ($c->schedule as $s) {
        // echo $s;
        //CHECK MONTH
        if ($c->shedule_type == 'yearly') {
            $pass = false;
            if ($s->month == $currentTime->format('m')) {
                if ($s->day == $currentTime->format('l')) {
                    $pass = true;
                } elseif ($s->day == $currentTime->format('j')) {
                    $pass = true;
                }
            }
        }
        //CHECK DAY
        if ($c->shedule_type == 'monhly') {
            $pass = false;
            if ($s->day == $currentTime->format('l')) {
                $pass = true;
                echo 'll';
            } elseif ($s->day == $currentTime->format('j')) {
                $pass = true;
                echo 'jj';
            }
        }
        //CHECK TIME
        //CHECK DAY
        if ($c->shedule_type == 'daily') {
            $pass = true;
        }
        if ($pass) {
            $scheduleDb = explode(':', $s->time);
            $scheduleNow = explode(':', $currentTime->format('H:i'));
            if ($s->status == 0 && $scheduleDb[0] >= $scheduleNow[0]) {
                $count = $count + 1;
                if ($c->provider == 'provider3') {
                    echo $s;
                } else {
                    echo $s;
                }
            }
        }
    }
    return $count;
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
