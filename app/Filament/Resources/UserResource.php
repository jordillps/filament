<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Card;
use Livewire\TemporaryUploadedFile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;
use Filament\Facades\Filament;
use Filament\Forms\Components\MorphToSelect;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\Page;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    // protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                ->schema([
                    Forms\Components\FileUpload::make('photo_path')->avatar()->columnSpanFull()
                    ->disk('users-images')
                        ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                            return (string) str($file->getClientOriginalName())->prepend('user-'. date('d-m-Y-H-i-s-'));
                        }),
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\Select::make('roles')
                        ->multiple()
                        ->relationship('roles', 'name'),
                    Forms\Components\TextInput::make('email')
                        ->email()
                        ->unique(ignoreRecord: true)
                        ->required()
                        ->maxLength(255),
                    Forms\Components\DatePicker::make('email_verified_at'),
                    Forms\Components\TextInput::make('password')
                        ->password()
                        ->label('Password')
                        ->required()
                        ->visibleOn('create')
                        ->rule(Password::default()),
                    Forms\Components\TextInput::make('password_confirmation')
                        ->password()
                        ->label('Confirm Password')
                        ->same('password')
                        ->required()
                        ->requiredWith('password')
                        ->visibleOn('create')
                        ->rule(Password::default()),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            Tables\Columns\TextColumn::make('id')->sortable(),
            Tables\Columns\ImageColumn::make('photo_path')->label('Imagen')->disk('users-images'),
            Tables\Columns\TextColumn::make('name')->sortable()->searchable(),
            Tables\Columns\TextColumn::make('roles.name')->sortable(),
            Tables\Columns\TextColumn::make('email')->sortable()->searchable(),
            Tables\Columns\TextColumn::make('email_verified_at')
            ->date('d-m-Y'),
            Tables\Columns\TextColumn::make('created_at')
            ->date('d-m-Y'),
        ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('changePassword')
            ->form([
                Forms\Components\TextInput::make('new_password')
                        ->password()
                        ->label('New Password')
                        ->required()
                        ->rule(Password::default()),
                Forms\Components\TextInput::make('new_password_confirmation')
                        ->password()
                        ->label('Confirm New Password')
                        ->same('new_password')
                        ->required()
                        ->rule(Password::default()),
            ])->action(function(User $record,array $data){
                $record->update([
                    'password' =>  Hash::make($data['new_password']),
                ]);
                Filament::notify('success', 'Password updated successfully');
            }),
            ])
            ->bulkActions([
                // Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
    


    //No-one can create a User
    public static function canCreate() :bool{
        return true;
    }

    //No-one can delete a User
    public static function canDelete(Model $record) :bool{
        return false;
    }

    public static function canDeleteAny() :bool{
        return false;
    }

    public static function getNavigationBadge(): ?string{
        // return Customer::count();
        return self::getModel()::count();
    }
}
