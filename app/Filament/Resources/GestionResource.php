<?php

namespace App\Filament\Resources;

use Filament\Tables;
use App\Models\Gestion;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use App\Filament\Resources\GestionResource\Pages;

class GestionResource extends Resource
{
    protected static ?string $model = Gestion::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $label = 'Gestión';
    protected static ?string $pluralLabel = 'Gestiones';

    protected static ?string $slug = 'gestion';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()->schema([
                    TextInput::make('nombre')->required()->label('Año de la Gestión')
                        ->numeric()
                        ->minValue(2000)
                        ->maxValue(2050)
                        ->default(fn() => date('Y'))
                        ->unique()
                ])->columns([
                    'sm' => 2,
                    'xl' => 2,
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nombre')
            ])
            ->filters([
                //
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGestions::route('/'),
            'create' => Pages\CreateGestion::route('/crear'),
            'edit' => Pages\EditGestion::route('/{record}/editar'),
        ];
    }
}
