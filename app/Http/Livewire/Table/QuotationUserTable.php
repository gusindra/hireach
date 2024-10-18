<?php

namespace App\Http\Livewire\Table;

use App\Models\Quotation;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\NumberColumn;

class QuotationUserTable extends LivewireDatatable
{
    public $user;

    public function builder()
    {
        return Quotation::query()->where('user_id', $this->user->id);
    }

    public function columns()
    {
        return [
            Column::name('type')
                ->label('Type')
                ->searchable(),

            Column::name('title')
                ->label('Title')
                ->searchable(),

            Column::name('description')
                ->label('Description'),

            Column::name('quote_no')
                ->label('Quote No')
                ->searchable(),

            NumberColumn::name('commerce_id')
                ->label('Commerce ID'),

            Column::name('source_id')
                ->label('Source ID'),

            Column::name('client_id')
                ->label('Client ID'),

            Column::name('model')
                ->label('Model'),

            Column::name('model_id')
                ->label('Model ID'),

            Column::name('terms')
                ->label('Terms'),

            NumberColumn::name('discount')
                ->label('Discount'),

            NumberColumn::name('price')
                ->label('Price'),

            Column::name('status')
                ->label('Status'),

            NumberColumn::name('valid_day')
                ->label('Valid Days'),

            DateColumn::name('date')
                ->label('Date')
                ->format('d M Y'),
        ];
    }
}
