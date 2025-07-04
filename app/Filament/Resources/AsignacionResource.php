<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AsignacionResource\Pages;
use App\Filament\Resources\AsignacionResource\RelationManagers;
use App\Models\Asignacion;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AsignacionResource extends Resource
{
    protected static ?string $model = Asignacion::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $label = 'Asignacion';
    protected static ?string $pluralLabel = 'Asignaciones';

    protected static ?string $slug = 'asignacion';

    protected static ?string $navigationGroup = 'Otros';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\Select::make('docente_id')
                            ->label('Docente')
                            ->relationship('docente', 'nombre')
                            ->searchable()
                            ->getOptionLabelFromRecordUsing(
                                fn($record) => $record->nombre . ' ' . $record->ap_paterno . ' ' . $record->ap_materno
                            )
                            ->required()
                            ->reactive(),

                        Forms\Components\Select::make('gestion_id')
                            ->label('Gestión')
                            ->relationship('gestion', 'nombre')
                            ->default(function () {
                                return \App\Models\Configuracion::first()->gestion_id ?? null;
                            })
                            ->required(),

                        Forms\Components\Placeholder::make('datos_docente')
                            ->label('Datos del Docente')
                            ->content(function (callable $get) {
                                $id = $get('docente_id');

                                if (!$id) {
                                    return 'Seleccione un docente.';
                                }

                                $doc = \App\Models\Personal::find($id);
                                if (!$doc) {
                                    return 'Docente no encontrado.';
                                }

                                $lineas = [];
                                $lineas[] = "**Nombre completo:** {$doc->nombre} {$doc->ap_paterno} {$doc->ap_materno}";
                                $lineas[] = "**CI:** {$doc->ci}";

                                if ($doc->telefono) {
                                    $lineas[] = "**Teléfono:** {$doc->telefono}";
                                }

                                if ($doc->correo_electronico) {
                                    $lineas[] = "**Correo electrónico:** {$doc->correo_electronico}";
                                }

                                return implode("\n", $lineas);
                            })
                            ->columnSpanFull()
                            ->reactive(),

                        Forms\Components\Select::make('curso_id')
                            ->label('Curso')
                            ->relationship('curso', 'nombre')
                            ->required()
                            ->reactive(),

                        Forms\Components\Select::make('materia_id')
                            ->label('Materia')
                            ->relationship('materia', 'nombre')
                            ->required(),

                        Forms\Components\Checkbox::make('estado')
                            ->label('Estado')
                            ->default(true)
                            ->required()
                            ->hiddenOn(Pages\CreateAsignacion::class),

                        Forms\Components\DatePicker::make('fecha')
                            ->label('Fecha')
                            ->default(now())
                            ->required(),

                        Forms\Components\Textarea::make('descripcion')
                            ->label('Descripción'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('docente.nombre')
                    ->label('Docente')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('gestion.nombre')
                    ->label('Gestión')
                    ->sortable(),
                Tables\Columns\TextColumn::make('curso.nombre')
                    ->label('Curso')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('estado')
                    ->label('Estado')
                    ->badge()
                    ->color(fn(bool $state): string => $state ? 'success' : 'danger')
                    ->formatStateUsing(fn(bool $state): string => $state ? 'Activo' : 'Inactivo'),
                Tables\Columns\TextColumn::make('fecha')
                    ->label('Fecha')
                    ->date()
                    ->sortable(),
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
            'index' => Pages\ListAsignacions::route('/'),
            'create' => Pages\CreateAsignacion::route('/crear'),
            'edit' => Pages\EditAsignacion::route('/{record}/editar'),
        ];
    }
}
