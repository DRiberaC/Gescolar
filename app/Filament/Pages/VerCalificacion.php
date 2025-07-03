<?php

namespace App\Filament\Pages;

use App\Filament\Resources\CalificacionResource;
use Filament\Pages\Page;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder; // Asegúrate de importar Builder

use App\Models\Asignacion as ModeloAsignacion;
use App\Models\Calificacion as ModeloCalificacion;


class VerCalificacion extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.ver-calificacion';

    protected static bool $shouldRegisterNavigation = false;

    public ?int $asignacionId = null; // Propiedad para almacenar el ID

    public ?ModeloAsignacion $asignacion = null;

    public ?ModeloCalificacion $calificacion = null;


    // El método mount se ejecuta al cargar la página
    public function mount(): void
    {
        // Obtenemos el 'asignacionId' de la URL y lo asignamos a la propiedad
        $this->asignacionId = request()->query('asignacionId');

        // Es una buena práctica abortar si el ID no existe para evitar errores
        abort_if(!$this->asignacionId, 404);

        if ($this->asignacionId) {
            $this->asignacion = ModeloAsignacion::find($this->asignacionId);
        }
    }

    public function table(Table $table): Table
    {
        return $table
            // Modificamos la consulta base para filtrar por asignacion_id
            ->query(
                ModeloCalificacion::query()->where('asignacion_id', $this->asignacionId)
            )
            ->columns([
                TextColumn::make('tipo')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('fecha')
                    ->date('d/m/Y')
                    ->sortable(),
                TextColumn::make('descripcion')
                    ->limit(50) // Limitar el texto para que no sea muy largo
                    ->searchable(),
                // Ya no es necesario mostrar la columna Asignación ID, porque todas son de la misma
            ])
            ->filters([
                //
            ])
            ->actions([
                \Filament\Tables\Actions\Action::make('ver')
                    ->label('Ver asistencia')
                    ->icon('heroicon-o-eye')
                    ->url(fn($record) => route('filament.admin.pages.ver-calificacion-detalle', ['calificacionId' => $record->id])),
                \Filament\Tables\Actions\EditAction::make()
                    ->label('Editar')
                    ->icon('heroicon-o-pencil-square')
                    ->form([
                        \Filament\Forms\Components\Select::make('tipo')
                            ->label('Tipo de Calificación')
                            ->options([
                                'practico' => 'Práctico',
                                'parcial' => 'Parcial',
                                'final' => 'Final',
                            ])
                            ->required(),

                        \Filament\Forms\Components\DatePicker::make('fecha')
                            ->label('Fecha')
                            ->required(),

                        \Filament\Forms\Components\Textarea::make('descripcion')
                            ->label('Descripción')
                            ->required()
                            ->columnSpanFull(),
                    ])
                    ->modalWidth('xl') // Opcional: ajusta el ancho del modal
                    ->successNotificationTitle('Calificación actualizada'), // Mensaje de éxito personalizado

                // Sugerencia: Puedes añadir una acción para eliminar fácilmente
                \Filament\Tables\Actions\DeleteAction::make()->label('Eliminar'),
            ])
            ->bulkActions([
                //
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\Action::make('create_calificacion') // Cambiado el nombre para mayor claridad
                ->label('Nueva Calificación')
                ->icon('heroicon-o-plus-circle')
                ->size(\Filament\Support\Enums\ActionSize::Large)
                ->color('primary')

                // Aquí se define el formulario que aparecerá en el modal
                ->form([
                    \Filament\Forms\Components\Select::make('tipo')
                        ->label('Tipo de Calificación')
                        ->options([
                            'practico' => 'Práctico',
                            'parcial' => 'Parcial',
                            'final' => 'Final',
                        ])
                        ->required(),

                    \Filament\Forms\Components\DatePicker::make('fecha')
                        ->label('Fecha')
                        ->required()
                        ->default(now()), // Por defecto la fecha actual

                    \Filament\Forms\Components\Textarea::make('descripcion')
                        ->label('Descripción')
                        ->columnSpanFull(), // Ocupa todo el ancho
                ])

                // Esta es la lógica que se ejecuta al enviar el formulario
                ->action(function (array $data) {
                    // Combinamos los datos del formulario con el asignacion_id de la página
                    $calificacionData = array_merge($data, [
                        'asignacion_id' => $this->asignacionId,
                    ]);

                    // Creamos el registro en la base de datos
                    $this->calificacion = ModeloCalificacion::create($calificacionData);

                    if ($this->asignacion && $this->asignacion->curso) {
                        $matriculas = $this->asignacion->curso->matriculas;
                        foreach ($matriculas as $matricula) {
                            $estudiante = $matricula->estudiante;
                            $this->calificacion->detalles()->create([
                                'nota' => 0,
                                'estudiante_id' => $estudiante->id,
                            ]);
                        }
                    }

                    // Enviamos una notificación de éxito
                    \Filament\Notifications\Notification::make()
                        ->title('Calificación creada exitosamente')
                        ->success()
                        ->send();
                }),
        ];
    }
}
