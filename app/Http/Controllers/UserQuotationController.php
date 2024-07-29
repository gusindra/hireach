<?php

namespace App\Http\Controllers;

use App\Models\Quotation;
use Illuminate\Http\Request;

class UserQuotationController extends Controller
{
    public function quotation()
    {
        $this->authorize('VIEW_ANY_CHAT_USR');
        return view('payment.quotation');
    }
    public function quotationShow($id)
    {
        $data = Quotation::find($id);

        $this->authorize('VIEW_CONTENT_USR', $data->model_id);
        return view('payment.show-quotation', compact('data'));
    }
}
