<?php

namespace App\Filament\Pages;

use App\Models\Asignacion;
use Filament\Pages\Page;

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


    // public function mount(): void
    // {
    //     $this->asignaciones = Asignacion::all();
    // }

    public function table(Table $table): Table
    {
        return $table
            ->query(Asignacion::query())
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('ID')->sortable(),
                Tables\Columns\TextColumn::make('nombre')->label('Nombre')->searchable(),
                Tables\Columns\TextColumn::make('descripcion')->label('Descripción')->wrap(),
                Tables\Columns\TextColumn::make('created_at')->label('Creado')->dateTime(),
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
