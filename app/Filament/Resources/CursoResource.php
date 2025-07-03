<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CursoResource\Pages;
use App\Filament\Resources\CursoResource\RelationManagers;
use App\Models\Curso;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CursoResource extends Resource
{
    protected static ?string $model = Curso::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $label = 'Curso';
    protected static ?string $pluralLabel = 'Cursos';

    protected static ?string $slug = 'curso';

    protected static ?string $navigationGroup = 'Configuración';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nombre')
                    ->required()
                    ->maxLength(255)
                    ->readOnly(),

                Forms\Components\Select::make('gestion_id')
                    ->label('Gestión')
                    ->relationship('gestion', 'nombre')
                    ->default(function () {
                        return \App\Models\Configuracion::first()->gestion_id ?? null;
                    })
                    ->required(),

                Forms\Components\Select::make('nivel_id')
                    ->label('Nivel')
                    ->reactive()
                    ->relationship('nivel', 'nombre')
                    ->required()
                    ->afterStateUpdated(fn($state, callable $set, callable $get) => static::actualizarNombre($set, $get)),

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
                    ->afterStateUpdated(fn($state, callable $set, callable $get) => static::actualizarNombre($set, $get))
                    ->required()
                    ->disabled(fn(callable $get) => !$get('nivel_id')),

                Forms\Components\Select::make('paralelo_id')
                    ->label('Paralelo')
                    ->reactive()
                    ->options(function (callable $get) {
                        $gradoId = $get('grado_id');
                        if (!$gradoId) {
                            return [];
                        }
                        return \App\Models\Paralelo::where('grado_id', $gradoId)
                            ->pluck('nombre', 'id')
                            ->toArray();
                    })
                    ->afterStateUpdated(fn($state, callable $set, callable $get) => static::actualizarNombre($set, $get))
                    ->required()
                    ->disabled(fn(callable $get) => !$get('grado_id')),

                Forms\Components\Select::make('turno_id')
                    ->label('Turno')
                    ->reactive()
                    ->relationship('turno', 'nombre')
                    ->afterStateUpdated(fn($state, callable $set, callable $get) => static::actualizarNombre($set, $get))
                    ->required(),

                Forms\Components\Textarea::make('descripcion')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nombre')
                    ->searchable(),
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
                Tables\Columns\TextColumn::make('turno.nombre')
                    ->label('Turno')
                    ->numeric()
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
            'index' => Pages\ListCursos::route('/'),
            'create' => Pages\CreateCurso::route('/crear'),
            'edit' => Pages\EditCurso::route('/{record}/editar'),
        ];
    }

    public static function actualizarNombre(callable $set, callable $get)
    {
        $gradoId = $get('grado_id');
        $nivelId = $get('nivel_id');
        $paraleloId = $get('paralelo_id');
        $turnoId = $get('turno_id');

        $grado = $gradoId ? \App\Models\Grado::find($gradoId)?->nombre : null;
        $nivel = $nivelId ? \App\Models\Nivel::find($nivelId)?->nombre : null;
        $paralelo = $paraleloId ? \App\Models\Paralelo::find($paraleloId)?->nombre : null;
        $turno = $turnoId ? \App\Models\Turno::find($turnoId)?->nombre : null;

        // \Filament\Notifications\Notification::make()
        //     ->success()
        //     ->title("{$grado} de {$nivel} {$paralelo}")
        //     ->send();

        if ($grado && $nivel && $paralelo && $turno) {
            $nombre = "{$grado} de {$nivel} {$paralelo} - {$turno}";
            $set('nombre', $nombre);
        } else {
            $set('nombre', null);
        }
    }
}
