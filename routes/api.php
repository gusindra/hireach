<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiWaController;
use App\Http\Controllers\TestApiController;
use App\Http\Controllers\ApiTeamWaController;
use App\Http\Controllers\ApiBulkSmsController;
use App\Http\Controllers\ApiChatController;
use App\Http\Controllers\ApiOneWayController;
use App\Http\Controllers\ApiSmsController;
use App\Http\Controllers\ApiTwoWayController;
use App\Http\Controllers\ApiRequestController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/wa/{messege}',  [ApiWaController::class, 'show']);
Route::post('/wa',  [ApiWaController::class, 'retriveNewMessage']);
Route::post('/webhook/{slug}',  [ApiWaController::class, 'inbounceMessage'])->name('api.client.webhook');
// Route::get('/chat/{phone}',  [TestApiController::class, 'get']);

Route::middleware(['auth:sanctum'])->group(function () {
    // sample key : kHy717zKGKN9Xwt1GdD14JryEBsLFApJSEiG1Gmy = telixcel
    // sample 1 : QxYBf46DyeSSsuXKf6tWWpd0rZBVT1a8dFeFSOyM = gusin
    Route::get('/test',  [TestApiController::class, 'get']);
    Route::post('/test',  [TestApiController::class, 'post']);
    Route::post('/bulksms',  [ApiBulkSmsController::class, 'post']);

    // API for chat
    Route::get('/getmsg/{id}',  [TestApiController::class, 'get']);
    Route::post('/sendmsg/{id}',  [TestApiController::class, 'post']);

    // API for chat
    Route::get('/chat/{phone}',  [ApiChatController::class, 'show']);
    Route::post('/chat',  [ApiChatController::class, 'post']);
    Route::post('/chat/bulk',  [ApiChatController::class, 'post']);
    // API for sms
    Route::get('/sms',  [ApiSmsController::class, 'index']);
    Route::get('/sms/{phone}',  [ApiSmsController::class, 'show']);
    Route::post('/sms',  [ApiSmsController::class, 'post']);
    Route::post('/sms/bulk',  [ApiSmsController::class, 'sendBulk']);

    //API for 1Way
    Route::get('/one-way',  [ApiOneWayController::class, 'index']);
    Route::post('/one-way',  [ApiOneWayController::class, 'post']);
    //API for 2Way
    Route::get('/two-way',  [ApiTwoWayController::class, 'index']);
    Route::post('/two-way',  [ApiTwoWayController::class, 'post']);
});

//Route::get('/test',  [TestApiController::class, 'get']);
Route::get('/test/{id}',  [TestApiController::class, 'show']);
Route::get('/send/smsbulk',  [TestApiController::class, 'smsbulk']);
Route::put('/test/{id}',  [TestApiController::class, 'put']);

Route::get('/team-auth',  [ApiTeamWaController::class, 'getAuth']);
Route::post('/post-team-auth',  [ApiTeamWaController::class, 'postTeamAuth'])->name('wa.session');
Route::get('/test/{id}',  [ApiTeamWaController::class, 'getTeam']);
Route::put('/team-auth/{id}',  [ApiTeamWaController::class, 'put']);


//MO & DN URL
//Route::get('/receive-request-status',  [ApiRequestController::class, 'status']);
//Route::get('/log-request-status',  [ApiRequestController::class, 'logStatus']);
Route::post('/delivery-notification ',  [ApiBulkSmsController::class, 'status']);
//Route::get('/log-request-status1',  [ApiBulkSmsController::class, 'logStatus']);
Route::post('/inbound-messages',  [ApiWaController::class, 'retriveNewMessage']);

Route::get('/sample/message', function (Request $request) {
    if($request->has('status')){
        if($request->status=='accepted'){
            return response()->json([
                'message_status' => [
                    'message_id' => '100000000050',
                    'recipient' => '601265',
                    'status' => 'ACCEPTED',
                ]
            ]);
        }
        if($request->status=='read'){
            return response()->json([
                'message_status' => [
                    'message_id' => '100000000050',
                    'recipient' => '601265',
                    'status' => 'ACCEPTED',
                ]
            ]);
        }
        if($request->status=='delete'){
            return response()->json([
                'message_status' => [
                    'message_id' => '100000000050',
                    'recipient' => '601265',
                    'status' => 'DELETE',
                ]
            ]);
        }
        if($request->status=='undelivered'){
            return response()->json([
                'message_status' => [
                    'message_id' => '100000000050',
                    'recipient' => '601265',
                    'status' => 'UNDELIVERED',
                ]
            ]);
        }
        if($request->status=='accepted'){
            return response()->json([
                'message_status' => [
                    'message_id' => '100000000050',
                    'recipient' => '601265',
                    'status' => 'DELIVERED',
                ]
            ]);
        }
    }
    return response()->json([
                'Msg' => "Failed",
                'Status' => 400
            ]);
});

Route::get('/sent/sample', function(Request $request){
    if($request->channel){
        if(false){
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
              "Content-Type: application/json"
            ));
            curl_setopt($curl, CURLOPT_URL,
              "https://api.smtp2go.com/v3/email/send"
            );
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode(array(
              "api_key" => "api-DC84566695C24F1E81D5B0EAAA0B1F50",
              "sender" => "norply@hireach.archeeshop.com",
              "to" => array(
                0 => "saritune@gmail.com"
              ),
              "subject" => "testing api email hi",
              "html_body" => "<h1>hello this is testing number 2 from sandbox hireach</h1>",
              "text_body" => "hello this is testing number 2 from sandbox hireach"
            )));
            $result = curl_exec($curl);
            echo $result;
        }else{
            Mail::raw('Text to e-mail', function($message)
            {
                $message->from('saritune@gmail.com', 'Laravel');
                $message->to('gusin44@yahoo.com');
            });
        }
        return 'success sending '.$request->channel;
    }else{
        return 'comming soon we add '.$request->channel;
    }
});