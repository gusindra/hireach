<?php

namespace App\Http\Livewire\Table;

use App\Models\BlastMessage;
use App\Models\Client;
use App\Models\OperatorPhoneNumber;
use Carbon\Carbon;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\BooleanColumn;

class SmsBlastTable extends LivewireDatatable
{
    public $model = Client::class;
    public $hideable = 'select';
    public $userId = 0;
    public $month;
    public $year;
    public $export_name = 'SMS_REQUEST';
    public $filterMonth;

    public function builder()
    {
        $query = BlastMessage::query();

        if (!$this->filterMonth) {
            $year = Carbon::now()->year;
            $month = Carbon::now()->month;
        } else {
            $year = substr($this->filterMonth, 0, 4);
            $month = substr($this->filterMonth, 5, 2);
        }

        if (auth()->user()->super && auth()->user()->super->first() && auth()->user()->super->first()->role == 'superadmin') {
            if($this->userId != 0){
                $query->where('blast_messages.user_id', $this->userId)->orderBy('created_at', 'desc');
            }else{
                $query->orderBy('created_at', 'desc');
            }
            $query->withTrashed();
        } elseif (auth()->user()->activeRole && str_contains(auth()->user()->activeRole->role->name, "Admin")) {
            $query->orderBy('created_at', 'desc');
        } else {
            $query->where('blast_messages.user_id', auth()->user()->currentTeam->user_id)->orderBy('created_at', 'desc');
            $query->whereYear('created_at', $year)
            ->whereMonth('created_at', $month);
        }

        return $query;
    }

    /**
     * clientTbl
     *
     * @return array
     */
    private function clientTbl()
    {
        return [
            Column::callback(['status'], function ($y) {
                return view('label.type', ['type' => $y]);
            })->label('Status')->exportCallback(function ($value) {
                return (string) $value;
            }),
            Column::callback(['client_id'], function ($client_id) {
                return $client_id;
            })->label('Client')->truncate(12)->filterable()->label('Client')->hide()->exportCallback(function ($value) {
                return (string) $value;
            }),
            Column::name('sender_id')->label('Sender Name'),
            Column::name('msisdn')->label('Client'),
            Column::name('message_content')->label('Message Content')->truncate(50),
            DateColumn::name('created_at')->label('Creation Date')->sortBy('created_at', 'desc')->format('d-m-Y H:i:s')->alignRight(),
            Column::name('status')->label('Status')->hide(),
            BooleanColumn::name('otp')->hide()->label('OTP')
        ];
    }

    /**
     * adminTbl
     *
     * @return array
     */
    private function adminTbl()
    {
        return [
            Column::callback(['id', 'msisdn', 'status', 'msg_id', 'code'], function ($id, $m, $s, $mid, $c) {
                return view('tables.sms-action', ['id' => $id, 'msisdn' => $m, 'status' => $s, 'mid' => $mid, 'code' => $c]);
            })->label('Action'),
            Column::callback(['status'], function ($y) {
                return view('label.type', ['type' => $y]);
            })->label('Status')->filterable(['DELIVERED', 'UNDELIVERED', 'ACCEPTED', 'PROCESSING', 'PROCESSED', 'REJECT INVALID SERVID'])->label('Status')->exportCallback(function ($value) {
                return (string) $value;
            }),
            Column::name('user_id')->callback(['user_id'], function ($value) {
                return view('datatables::link', [
                    'href' => "/admin/user/" . $value,
                    'slot' => $value
                ]);
            })->label('User')->filterable()->exportCallback(function ($value) {
                return (string) $value;
            }),
            DateColumn::name('updated_at')->hide()->label('Update Date')->filterable()->format('d-m-Y H:i:s'),
            DateColumn::name('created_at')->label('Creation Date')->sortBy('created_at', 'desc')->filterable()->format('d-m-Y H:i:s'),
            Column::name('price')->label('Price'),
            Column::name('msg_id')->label('Sending ID'),
            Column::name('client_id')->hide()->label('Client')->filterable(),
            Column::name('message_content')->label('Message Content')->filterable(),
            Column::name('msisdn')->label('Phone No')->filterable(),
            Column::name('sender_id')->label('Sender Name')->filterable(),
            Column::name('status')->label('Status')->hide(),
            Column::callback(['msisdn'], function ($nohp) {
                $text = "-";
                if (strlen($nohp) > 6) {
                    $op = OperatorPhoneNumber::where('code', substr($nohp, 0, 5))->first();
                    if ($op) {
                        return $op->operator;
                    }
                }
                return $text;
            })->label('OP')->hide()->filterable(),
            BooleanColumn::name('otp')->label('OTP')
        ];
    }

    public function columns()
    {
        if ((auth()->user()->super && auth()->user()->super->first() && auth()->user()->super->first()->role == 'superadmin') || (auth()->user()->activeRole && str_contains(auth()->user()->activeRole->role->name, "Admin"))) {
            return $this->adminTbl();
        }
        return $this->clientTbl();
    }

    public function cellClasses($row, $column)
    {
        //return $row->{'status'};
        $extra = '';
        if (str_contains(strtolower($row->{'status'}), 'invalid')) {
            $extra = 'w-1/4';
        }
        return 'px-2 text-xs ' . $extra;
    }
}
