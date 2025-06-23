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

    protected static ?string $slug = 'Asignacion';

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

                        Forms\Components\Placeholder::make('break1')->label(''),

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

                        Forms\Components\Select::make('gestion_id')
                            ->label('Gestión')
                            ->relationship('gestion', 'nombre')
                            ->required(),

                        Forms\Components\Select::make('nivel_id')
                            ->label('Nivel')
                            ->relationship('nivel', 'nombre')
                            ->required()
                            ->reactive(),

                        Forms\Components\Select::make('grado_id')
                            ->label('Grado')
                            ->reactive()
                            ->options(function (callable $get) {
                                $nivelId = $get('nivel_id');
                                if (!$nivelId) {
                                    return [];
                                }
                                return \App\Models\Grado::where('nivel_id', $nivelId)
                                    ->pluck('nombre', 'id')
                                    ->toArray();
                            })
                            ->afterStateUpdated(function ($state, callable $set) {
                                $set('paralelo_id', null);
                            })
                            ->required()
                            ->disabled(fn(callable $get) => !$get('nivel_id')),

                        Forms\Components\Select::make('paralelo_id')
                            ->label('Paralelo')
                            ->options(function (callable $get, callable $set, $livewire) {

                                $gradoId = $get('grado_id');
                                if (!$gradoId) {
                                    return [];
                                }

                                return \App\Models\Paralelo::where('grado_id', $gradoId)
                                    ->pluck('nombre', 'id')
                                    ->toArray();
                            })
                            ->required()
                            ->disabled(fn(callable $get) => !$get('grado_id')),

                        Forms\Components\Select::make('materia_id')
                            ->label('Materia')
                            ->relationship('materia', 'nombre')
                            ->required(),

                        Forms\Components\Select::make('turno_id')
                            ->label('Turno')
                            ->relationship('turno', 'nombre')
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
                Tables\Columns\TextColumn::make('nivel.nombre')
                    ->label('Nivel')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('grado.nombre')
                    ->label('Grado')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('paralelo.nombre')
                    ->label('Paralelo')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('materia.nombre')
                    ->label('Materia')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('turno.nombre')
                    ->label('Turno')
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
