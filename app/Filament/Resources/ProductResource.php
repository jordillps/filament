<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Livewire\TemporaryUploadedFile;
use Filament\Tables\Columns\Layout\Split;
use Closure;
use Illuminate\Support\Str;
use AlperenErsoy\FilamentExport\Actions\FilamentExportHeaderAction;



class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?string $modelLabel = 'producto';

    protected static ?string $pluralModelLabel = 'productos';

    protected static ?string $navigationGroup = 'Gestión';

    protected static ?int $navigationSort = 3;


    //To search globally in this resource
    protected static ?string $recordTitleAttribute = 'name';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                ->schema([
                Forms\Components\TextInput::make('name')->required()->maxLength(255)
                ->reactive()
                ->afterStateUpdated(function (Closure $set, $state) {
                    $set('slug', Str::slug($state));
                }),
                Forms\Components\TextInput::make('slug')->required()->maxLength(255),
                Forms\Components\Textarea::make('description')->required()->maxLength(65535),
                Select::make('processes')
                            ->multiple()
                            ->relationship('processes', 'name'),
                Forms\Components\TextInput::make('price')->type('number')->step('any')
                    ->rule('numeric')->disabled(),
                Forms\Components\FileUpload::make('photo_path')->image()
                    ->disk('products-images')
                    ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                        return (string) str($file->getClientOriginalName())->prepend('product-'. date('d-m-Y-H-i-s-'));
                    })
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Split::make([
                    Tables\Columns\TextColumn::make('id')->sortable()->searchable(),
                    Tables\Columns\ImageColumn::make('photo_path')->disk('products-images')->width(40)->height(40),
                    Tables\Columns\TextColumn::make('name')->sortable()->searchable(),
                    Tables\Columns\TextColumn::make('price')->money('eur')->sortable()->extraAttributes(['class' => 'text-right']),
                    Tables\Columns\TextColumn::make('processes_count')
                    ->counts('processes')->label('Procesos'),
                    Tables\Columns\TextColumn::make('created_at')
                        ->date('d-m-Y'),
                    // ])
            ])
            ->filters([
                //
            ])
            ->headerActions([
                FilamentExportHeaderAction::make('export')
                ->timeFormat('d-m-Y') // Default time format for naming exports
                ->defaultFormat('pdf') // xlsx, csv or pdf
                ->defaultPageOrientation('landscape') // Page orientation for pdf files. portrait or landscape
                ->disableAdditionalColumns(false) // Disable additional columns input
                ->disableFilterColumns(false) // Disable filter columns input
                ->disableFileName(false) // Disable file name input
                ->disableFileNamePrefix(false) // Disable file name prefix
                ->disablePreview(false) // Disable export preview
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()->disabled(function(Product $record){
                    if($record->lineOrders->count() > 0){
                        return true;
                    }
                }),
            ])
            ->bulkActions([
                // Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            RelationManagers\ProcessesRelationManager::class,
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
    
    public static function getNavigationBadge(): ?string{
        // return Customer::count();
        return self::getModel()::count();
    }
}
