<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GradoResource\Pages;
use App\Filament\Resources\GradoResource\RelationManagers;
use App\Models\Grado;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GradoResource extends Resource
{
    protected static ?string $model = Grado::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $label = 'Grado';
    protected static ?string $pluralLabel = 'Grados';

    protected static ?string $slug = 'grado';

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

                    Forms\Components\Select::make('nivel_id')
                        ->label('Nivel')
                        ->relationship('nivel', 'nombre')
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
                Tables\Columns\TextColumn::make('nivel.nombre')->sortable()->label('Nivel'),
                Tables\Columns\TextColumn::make('created_at')->dateTime(),
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
            'index' => Pages\ListGrados::route('/'),
            'create' => Pages\CreateGrado::route('/crear'),
            'edit' => Pages\EditGrado::route('/{record}/editar'),
        ];
    }
}
