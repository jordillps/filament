<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use App\Models\Order;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Filament\Tables\Contracts\HasRelationshipTable;

class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;

    protected function mutateFormDataBeforeCreate( array $data): array{
        $lastOrder = Order::orderBy('created_at', 'desc')->orderBy('id', 'desc')->first();
        if ($lastOrder == null) {
            $data['order_number'] = date("Y"). '-' . '0001';
        }else{
            $expNum = explode('-', $lastOrder->order_number);

            //check first day in a year
            if ( date('z') === '0' && $expNum[0] !=  date('Y')){
                $data['order_number'] = date('Y').'-0001';
            } else {
            //increase 1 with last invoice number
                $data['order_number'] = $expNum[0].'-'. sprintf("%04s", $expNum[1]+1);
            }
        }
        return $data;
    }


}
