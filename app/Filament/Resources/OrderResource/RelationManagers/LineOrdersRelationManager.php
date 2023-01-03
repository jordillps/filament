<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use App\Filament\Resources\LineOrderResource\Pages\EditLineOrder;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Hidden;
use App\Models\Product;
use App\Models\Order;
use App\Models\LineOrder;
use Illuminate\Database\Eloquent\Model;
use Filament\Tables\Contracts\HasRelationshipTable;
use Filament\Facades\Filament;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Pages\Actions\CreateAction;


class LineOrdersRelationManager extends RelationManager
{
    protected static string $relationship = 'lineOrders';

    protected static ?string $recordTitleAttribute = 'id';

    protected static ?string $modelLabel = 'Línea de Pedido';

    protected static ?string $pluralModelLabel = 'Líneas de Pedido';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('order_id')
                    ->relationship('order', 'id')->disabledOn('edit')->hiddenOn('create'),
                Select::make('product_id')
                    ->relationship('product', 'name', function (HasRelationshipTable $livewire,Builder $query) {
                        $currentOrderProducts = LineOrder::where('order_id', $livewire->ownerRecord->id)->pluck('product_id')->toArray();
                        $currentOrderProductsNames = Product::whereIn('id',$currentOrderProducts)->pluck('name')->toArray();
                        $query->whereNotIn('name', $currentOrderProductsNames);
                    })->disabledOn('edit')->required(),
                Forms\Components\TextInput::make('quantity')->required()->numeric()
                ->extraInputAttributes(['min' => 1, 'max' => 10, 'step' => 1]),   
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('order_id')->label('Pedido'),
                Tables\Columns\TextColumn::make('product.name'),
                Tables\Columns\TextColumn::make('quantity'),
                Tables\Columns\TextColumn::make('product.price')->label('Price')->money('eur')->extraAttributes(['class' => 'text-right']),
                Tables\Columns\TextColumn::make('subtotal')->money('eur', true)->extraAttributes(['class' => 'text-right']),
                Tables\Columns\TextColumn::make('created_at')
                    ->date('d-m-Y'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->using(function (HasRelationshipTable $livewire, array $data): Model {
                    $product = Product::where('id', $data['product_id'])->first();
                    $data['subtotal'] = round($data['quantity'] * $product->price , 2);
                    return $livewire->getRelationship()->create($data);
                })->after(function (HasRelationshipTable $livewire, array $data) {
                    $order = Order::where('id', $livewire->ownerRecord->id)->first();
                    $order->updateOrder();
                }),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->mutateFormDataUsing(function (array $data): array {
                    $product = Product::where('id', $data['product_id'])->first();
                    $data['subtotal'] = round($data['quantity'] * $product->price , 2);
                    return $data;
                })->after(function (array $data) {
                    $order = Order::where('id', $data['order_id'])->first();
                    $order->updateOrder();
                }),
                Tables\Actions\DeleteAction::make()
                ->after(function (HasRelationshipTable $livewire) {
                    $order = Order::where('id', $livewire->ownerRecord->id)->first();
                    $order->updateOrder();
                }),
            ])
            ->bulkActions([
                //Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    
    
}
