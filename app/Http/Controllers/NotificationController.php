<?php

namespace App\Http\Controllers;

use App\Models\FlowProcess;
use App\Models\Notice;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;

class NotificationController extends Controller
{
    public function index()
    {
        $currentDate = now()->format('Y-m-d');
        $filterDate = request()->input('filterDate', $currentDate);
        $statusFilter = request()->input('statusFilter', '');

        return view('notification', compact('filterDate', 'statusFilter'));
    }


    public function show(Notice $notification)
    {
        $notification->update(array('status' => 'read'));
        if ($notification->model == 'Ticket') {
            $value =  $notification->ticket->request->client->id;
        } elseif ($notification->model == 'Order') {
            return redirect()->to("/order/" . $notification->model_id);
        } elseif ($notification->model == 'Invoice' || $notification->model == 'INVOICE') {
            return redirect()->to("/invoice-order/" . $notification->model_id);
        } elseif ($notification->model == 'Balance') {
            return redirect()->to("/payment/deposit/");
        } elseif ($notification->model == 'Contract') {
            return redirect()->to("/commercial/contract/" . $notification->model_id);
        } elseif ($notification->model == 'FlowProcess') {
            $flow = FlowProcess::find($notification->model_id);
            if ($flow) {
                if ($flow->model == 'QUOTATION') {
                    return redirect()->to("/commercial/quotation/" . $flow->model_id);
                } elseif ($flow->model == 'PROJECT') {
                    return redirect()->to("/project/" . $flow->model_id);
                } elseif ($flow->model == 'CONTRACT') {
                    return redirect()->to("/commercial/contract/" . $flow->model_id);
                } elseif ($flow->model == 'ORDER') {
                    return redirect()->to("/order/" . $flow->model_id);
                } elseif ($flow->model == 'COMMISSION') {
                    return redirect()->to("/commission/" . $flow->model_id);
                } elseif ($flow->model == 'INVOICE') {
                    return redirect()->to("/invoice-order/" . $flow->model_id);
                }
            }
        } else {
            return redirect()->to("/message/?id=" . Hashids::encode($notification->id));
        }
        return redirect('dashboard');
    }

    public function readAll()
    {
        $notification = Notice::where('user_id', auth()->user()->id)->where('status', 'unread')->update([
            'status' => 'read'
        ]);
        return redirect()->back();
    }
}
