<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ParaleloResource\Pages;
use App\Filament\Resources\ParaleloResource\RelationManagers;
use App\Models\Paralelo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ParaleloResource extends Resource
{
    protected static ?string $model = Paralelo::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()->schema([
                    Forms\Components\TextInput::make('nombre')
                        ->required()
                        ->maxLength(255),

                    Forms\Components\Textarea::make('descripcion')
                        ->nullable(),

                    Forms\Components\Select::make('grado_id')
                        ->label('Grado')
                        ->relationship('grado', 'nombre')
                        ->required(),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('nombre')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('descripcion')->sortable()->limit(50),
                Tables\Columns\TextColumn::make('grado.nombre')->sortable()->label('Grado'),
                // Tables\Columns\TextColumn::make('created_at')->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListParalelos::route('/'),
            'create' => Pages\CreateParalelo::route('/crear'),
            'edit' => Pages\EditParalelo::route('/{record}/editar'),
        ];
    }
}
