<?php

namespace App\Filament\Pages;

use App\Models\Asignacion;
use Filament\Pages\Page;

use Illuminate\Support\Facades\Auth;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Tables;

class Asistencia extends Page implements HasTable
{

    use Tables\Concerns\InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.asistencia';

    protected static ?string $label = 'Asistencia';
    protected static ?string $pluralLabel = 'Asistencias';

    protected static ?string $slug = 'asistencia';

    public  $asignaciones;

    protected static ?string $navigationGroup = 'Otros';

    public function table(Table $table): Table
    {
        $user = Auth::user();
        $query = Asignacion::query();
        $personalId = $user->personal?->id;
        $query->where('docente_id', $personalId);

        // \Filament\Notifications\Notification::make()
        //     ->success()
        //     ->title('Data' . $user->id)
        //     ->send();

        return $table
            ->query($query)
            ->columns([
                Tables\Columns\TextColumn::make('gestion.nombre')->label('Gestión')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('curso.nombre')->label('Curso')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('materia.nombre')->label('Materia')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('descripcion')->label('Descripción')->wrap(),
            ])
            ->actions([
                \Filament\Tables\Actions\Action::make('ver')
                    ->label('Ver asistencia')
                    ->icon('heroicon-o-eye')
                    ->url(fn($record) => route('filament.admin.pages.ver-asistencia', ['asignacionId' => $record->id])),
            ])
        ;
    }
}
