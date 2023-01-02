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
                    ->relationship('order', 'id')->disabledOn('edit'),
                Select::make('product_id')
                    ->relationship('product', 'name')->disabledOn('edit')->required(),
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
                // CreateAction::make()
                //     ->using(function (HasRelationshipTable $livewire, array $data): Model {
                //     return $livewire->getRelationship()->create($data);
                // })
                Tables\Actions\CreateAction::make()->mutateFormDataUsing(function (array $data): array {
                    $product = Product::where('id', $data['product_id'])->first();
                    $data['subtotal'] = round($data['quantity'] * $product->price , 2);
                    return $data;
                })->after(function (array $data) {
                    $lineOrders = LineOrder::where('order_id', $data['order_id'])->pluck('subtotal')->toArray();
                    $order = Order::where('id', $data['order_id'])->first();
                    $order->subtotal = array_sum($lineOrders);
                    $order->tax = round($order->subtotal * 0.21,2);
                    $order->total = $order->subtotal + $order->tax;
                    $order->save();
                }),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->mutateFormDataUsing(function (array $data): array {
                    $product = Product::where('id', $data['product_id'])->first();
                    $data['subtotal'] = round($data['quantity'] * $product->price , 2);
                    return $data;
                })->after(function (array $data) {
                    $lineOrders = LineOrder::where('order_id', $data['order_id'])->pluck('subtotal')->toArray();
                    $order = Order::where('id', $data['order_id'])->first();
                    $order->subtotal = array_sum($lineOrders);
                    $order->tax = round($order->subtotal * 0.21,2);
                    $order->total = $order->subtotal + $order->tax;
                    $order->save();
                }),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                //Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
    
}
