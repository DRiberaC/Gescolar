<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PeriodoResource\Pages;
use App\Filament\Resources\PeriodoResource\RelationManagers;
use App\Models\Periodo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PeriodoResource extends Resource
{
    protected static ?string $model = Periodo::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?string $label = 'Periodo';
    protected static ?string $pluralLabel = 'Periodos';

    protected static ?string $slug = 'periodo';

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $navigationGroup = 'Configuración';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()->schema([
                    Forms\Components\TextInput::make('nombre')
                        ->required()
                        ->maxLength(255)
                        ->unique(ignoreRecord: true),

                    Forms\Components\Textarea::make('descripcion')
                        ->nullable(),

                    Forms\Components\Select::make('gestion_id')
                        ->label('Gestión')
                        ->relationship('gestion', 'nombre')
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
                Tables\Columns\TextColumn::make('gestion.nombre')->sortable()->label('Gestión'),
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
            'index' => Pages\ListPeriodos::route('/'),
            'create' => Pages\CreatePeriodo::route('/crear'),
            'edit' => Pages\EditPeriodo::route('/{record}/editar'),
        ];
    }
}
