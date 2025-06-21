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

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\Select::make('estudiante_id')
                            ->label('Estudiante')
                            // ->columnSpanFull()
                            ->relationship('estudiante', 'nombre')
                            ->searchable()
                            ->getOptionLabelFromRecordUsing(
                                fn($record) => $record->nombre . ' ' . $record->ap_paterno . ' ' . $record->ap_materno
                            )
                            ->required(),

                        Forms\Components\Placeholder::make('break1')->label(''),

                        Forms\Components\Select::make('gestion_id')
                            ->label('Gestión')
                            ->relationship('gestion', 'nombre')
                            ->required()
                            ->reactive(),

                        Forms\Components\Select::make('periodo_id')
                            ->label('Periodo')
                            ->options(function (callable $get) {
                                $gestionId = $get('gestion_id');
                                if (!$gestionId) {
                                    return [];
                                }

                                return \App\Models\Periodo::where('gestion_id', $gestionId)
                                    ->pluck('nombre', 'id')
                                    ->toArray();
                            })
                            ->required()
                            ->disabled(fn(callable $get) => !$get('gestion_id')),

                        Forms\Components\Select::make('nivel_id')
                            ->label('Nivel')
                            ->relationship('nivel', 'nombre')
                            ->required()
                            ->reactive(),

                        Forms\Components\Select::make('grado_id')
                            ->label('Grado')
                            ->reactive()
                            ->options(function (callable $get, callable $set) {
                                $nivelId = $get('nivel_id');

                                // Reset paralelo_id si cambia el grado_id
                                $set('paralelo_id', null);

                                if (!$nivelId) {
                                    return [];
                                }

                                return \App\Models\Grado::where('nivel_id', $nivelId)
                                    ->pluck('nombre', 'id')
                                    ->toArray();
                            })
                            ->required()
                            ->disabled(fn(callable $get) => !$get('nivel_id')),

                        Forms\Components\Select::make('paralelo_id')
                            ->label('Paralelo')
                            ->options(function (callable $get) {
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
                Tables\Columns\TextColumn::make('gestion.nombre')->sortable()->label('Gestión')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('periodo.nombre')->sortable()->label('Periodo')->sortable(),
                Tables\Columns\TextColumn::make('nivel.nombre')->sortable()->label('Nivel')->sortable(),
                Tables\Columns\TextColumn::make('grado.nombre')->sortable()->label('Grado')->sortable(),
                Tables\Columns\TextColumn::make('paralelo.nombre')->sortable()->label('Paralelo')->sortable(),
                // Tables\Columns\TextColumn::make('estudiante_id')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('gestion_id')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('periodo_id')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('nivel_id')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('grado_id')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('paralelo_id')
                //     ->numeric()
                //     ->sortable(),
                Tables\Columns\TextColumn::make('fecha')
                    ->date()
                    ->sortable(),
                // Tables\Columns\TextColumn::make('created_at')
                //     ->dateTime()
                //     ->sortable()
                //     ->toggleable(isToggledHiddenByDefault: true),
                // Tables\Columns\TextColumn::make('updated_at')
                //     ->dateTime()
                //     ->sortable()
                //     ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMatriculas::route('/'),
            'create' => Pages\CreateMatricula::route('/crear'),
            // 'edit' => Pages\EditMatricula::route('/{record}/editar'),
        ];
    }
}
