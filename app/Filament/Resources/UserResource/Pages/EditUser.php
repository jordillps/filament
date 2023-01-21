<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms;
use Filament\Resources\Form;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File; 


class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getActions(): array{
        return [
            // Actions\DeleteAction::make(),

            //Implement in the table

            // Actions\Action::make('changePassword')
            // ->form([
            //     Forms\Components\TextInput::make('new_password')
            //             ->password()
            //             ->label('New Password')
            //             ->required()
            //             ->rule(Password::default()),
            //     Forms\Components\TextInput::make('new_password_confirmation')
            //             ->password()
            //             ->label('Confirm New Password')
            //             ->same('new_password')
            //             ->required()
            //             ->rule(Password::default()),
            // ])->action(function(array $data){
            //     $this->record->update([
            //         'password' =>  Hash::make($data['new_password']),
            //     ]);
            //     $this->notify('success', 'Password updated successfully');
            // }),
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model{ 
        $fileCurrentImagePath = public_path(). '/img/users/' .$record->photo_path;
        if($record->photo_path != $data['photo_path']){
           if(File::exists($fileCurrentImagePath)){ 
                File::delete($fileCurrentImagePath);
            }
        }
        $record->update($data);
        return $record;
    }
}
