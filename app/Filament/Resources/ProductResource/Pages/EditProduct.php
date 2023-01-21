<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File; 

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model{ 
        $fileCurrentImagePath = public_path(). '/img/products/' .$record->photo_path;
        if($record->photo_path != $data['photo_path']){
           if(File::exists($fileCurrentImagePath)){ 
                File::delete($fileCurrentImagePath);
            }
        }
        $record->update($data);
        $record->updateProductPrice();
        return $record;
    }

    // Redirect to Index after creating this model
    protected function getRedirectUrl(): string{
        return $this->getResource()::getUrl('index');
    }
}
