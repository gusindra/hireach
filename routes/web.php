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
use App\Http\Controllers\ContactValidationResutController;
use App\Http\Controllers\FlowController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleInvitationController;
use App\Http\Controllers\TeamInvitationController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GenerateDataController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\UserChatController;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;

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
        Route::get('/user/{user}/dept', [UserController::class, 'department'])->name('user.show.dept');
        Route::get('/user/{user}/dept/{dept}', [UserController::class, 'departmentClient'])->name('user.show.dept.client');

        Route::get('/department', [UserController::class, 'listDepartment'])->name('admin.department');
        
        Route::get('/asset', [UserController::class, 'contact'])->name('admin.asset');
        
        Route::get('/contact', [UserController::class, 'contact'])->name('admin.contact');
        Route::get('/contact/duplicate', [UserController::class, 'duplicateContact'])->name('admin.contact-duplicate');
        Route::get('/contact/edit/{contact}', [UserController::class, 'contactEdit'])->name('admin.contact-edit');
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
        Route::get('/setting/product-line/{productLine}', [SettingController::class, 'productLineShow'])->name('settings.productLine.show');
        Route::get('/setting/commerce-item/{commerceItem}', [SettingController::class, 'commerceItemShow'])->name('settings.commerceItem.show');

        Route::get('/permission', [PermissionController::class, 'index'])->name('permission.index');
        Route::get('/setting/company', [SettingController::class, 'company'])->name('settings.company');
        Route::get('/setting/company/{company}', [SettingController::class, 'companyShow'])->name('settings.company.show');

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
        Route::get('/commercial/{key}/{id}', [CommercialController::class, 'edit'])->name('commercial.edit.show');
        Route::get('/commercial/{id}/{type}/print', [CommercialController::class, 'template'])->name('commercial.print');

        Route::get('/product/commercial/syn', [CommercialController::class, 'sync'])->name('commercial.sync');
        Route::post('/product/commercial/syn', [CommercialController::class, 'syncPost'])->name('commercial.sync.post');
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
    Route::get('/contact-validation', [ContactController::class, 'contactValidation'])->name('contactValidation.index');
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
        \Artisan::call('queue:work --tries=1 --stop-when-empty --timeout=60');
    } elseif ($id == "restart") {
        \Artisan::call('queue:restart');
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
Route::get('/import-validation', [ContactValidationResutController::class, 'importUpdateValidation'])->name('contacts.importFromPath');
Route::get('/generate/data/{provider}', [GenerateDataController::class, 'view'])->name('generate.data.api');
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
if(env('APP_ENV')=='local') include 'test.php';
