<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MatriculaResource\Pages;
use App\Filament\Resources\MatriculaResource\RelationManagers;
use App\Models\Matricula;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MatriculaResource extends Resource
{
    protected static ?string $model = Matricula::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $label = 'Matricula';
    protected static ?string $pluralLabel = 'Matriculas';

    protected static ?string $slug = 'matricula';

    protected static ?string $navigationGroup = 'Inscripciones';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\Select::make('estudiante_id')
                            ->label('Estudiante')
                            ->reactive()
                            ->relationship('estudiante', 'nombre')
                            ->searchable()
                            ->getOptionLabelFromRecordUsing(
                                fn($record) => $record->nombre . ' ' . $record->ap_paterno . ' ' . $record->ap_materno
                            )
                            ->required(),

                        Forms\Components\Select::make('gestion_id')
                            ->label('Gestión')
                            ->reactive()
                            ->relationship('gestion', 'nombre')
                            ->default(function () {
                                return \App\Models\Configuracion::first()->gestion_id ?? null;
                            })
                            ->required(),

                        Forms\Components\Placeholder::make('datos_estudiante')
                            ->label('Datos del estudiante')
                            ->reactive()
                            ->content(function (callable $get) {
                                $id = $get('estudiante_id');

                                if (!$id) {
                                    return 'Seleccione un estudiante.';
                                }

                                $est = \App\Models\Estudiante::find($id);
                                if (!$est) {
                                    return 'Estudiante no encontrado.';
                                }

                                $lineas = [];
                                $lineas[] = "**Nombre completo:** {$est->nombre} {$est->ap_paterno} {$est->ap_materno}";
                                $lineas[] = "**CI:** {$est->ci}";

                                if ($est->telefono) {
                                    $lineas[] = "**Teléfono:** {$est->telefono}";
                                }

                                if ($est->correo_electronico) {
                                    $lineas[] = "**Correo electrónico:** {$est->correo_electronico}";
                                }

                                return implode("\n", $lineas);
                            })
                            ->columnSpanFull(),



                        Forms\Components\Select::make('curso_id')
                            ->label('Cursos')
                            ->options(function (callable $get) {
                                $gestionId = $get('gestion_id');
                                if (!$gestionId) {
                                    return [];
                                }

                                return \App\Models\Curso::where('gestion_id', $gestionId)
                                    ->pluck('nombre', 'id')
                                    ->toArray();
                            })
                            ->required()
                            ->disabled(fn(callable $get) => !$get('gestion_id')),

                        Forms\Components\Placeholder::make('break1')->label(''),

                        Forms\Components\DatePicker::make('fecha')
                            ->label('Fecha')
                            ->default(fn() => now()->format('Y-m-d'))
                            ->required(),
                    ]),
            ]);
    }



    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('estudiante.nombre')->sortable()->label('Estudiante')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('curso.nombre')->sortable()->label('Curso')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('fecha')
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\PagosRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMatriculas::route('/'),
            'create' => Pages\CreateMatricula::route('/crear'),
            'view' => Pages\ViewMatricula::route('/{record}'),
            // 'edit' => Pages\EditMatricula::route('/{record}/editar'),
        ];
    }
}
