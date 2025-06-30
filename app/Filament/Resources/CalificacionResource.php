<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CalificacionResource\Pages;
use App\Filament\Resources\CalificacionResource\RelationManagers;
use App\Models\Calificacion;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CalificacionResource extends Resource
{
    protected static ?string $model = Calificacion::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $label = 'Calificacion';
    protected static ?string $pluralLabel = 'Calificaciones';

    protected static ?string $slug = 'calificacion';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        $query = \App\Models\Asignacion::query();
        $personalId = $user->personal?->id;
        $query->where('docente_id', $personalId);

        return $table
            ->query($query)
            ->columns([
                Tables\Columns\TextColumn::make('gestion.nombre')->label('Gestión')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('curso.nombre')->label('Curso')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('materia.nombre')->label('Materia')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('descripcion')->label('Descripción')->wrap(),
            ])
            ->filters([
                //
            ])
            ->actions([
                \Filament\Tables\Actions\Action::make('ver')
                    ->label('Ver')
                    ->icon('heroicon-o-eye')
                    ->url(fn($record) => route('filament.admin.pages.ver-calificacion', ['asignacionId' => $record->id])),
                // Tables\Actions\ViewAction::make(),
                // Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListCalificacions::route('/'),
            // 'create' => Pages\CreateCalificacion::route('/create'),
            // 'view' => Pages\ViewCalificacion::route('/{record}'),
            // 'edit' => Pages\EditCalificacion::route('/{record}/edit'),
        ];
    }
}
