<?php

namespace App\Filament\Resources\MatriculaResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PagosRelationManager extends RelationManager
{
    protected static string $relationship = 'pagos';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('monto')
                    ->label('Monto')
                    ->required()
                    ->numeric(),

                Forms\Components\DatePicker::make('fecha')
                    ->label('Fecha')
                    ->required(),

                Forms\Components\Textarea::make('descripcion')
                    ->label('Descripción'),

                Forms\Components\Select::make('metodo')
                    ->label('Método de pago')
                    ->options([
                        'efectivo' => 'Efectivo',
                        'transferencia' => 'Transferencia',
                        'tarjeta' => 'Tarjeta',
                    ])
                    ->required(),

                Forms\Components\Select::make('estado')
                    ->label('Estado')
                    ->options([
                        'pendiente' => 'Pendiente',
                        'completado' => 'Completado',
                        'anulado' => 'Anulado',
                    ])
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('ID')->sortable(),
                Tables\Columns\TextColumn::make('monto')->label('Monto')->money('Bs.'),
                Tables\Columns\TextColumn::make('fecha')->label('Fecha')->date(),
                Tables\Columns\TextColumn::make('descripcion')->label('Descripción')->wrap(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
