<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

use App\Models\Calificacion as ModeloCalificacion;

use App\Models\CalificacionDetalle as ModeloCalificacionDetalle;


class VerCalificacionDetalle extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.ver-calificacion-detalle';

    protected static bool $shouldRegisterNavigation = false;

    public ?int $calificacionId = null; // Propiedad para almacenar el ID

    public ?ModeloCalificacion $calificacion = null;

    // public ?ModeloCalificacionDetalle $calificacionDetalle = null;

    public $attendanceData = [];

    // El método mount se ejecuta al cargar la página
    public function mount(): void
    {
        // Obtenemos el 'asignacionId' de la URL y lo asignamos a la propiedad
        $this->calificacionId = request()->query('calificacionId');

        // Es una buena práctica abortar si el ID no existe para evitar errores
        abort_if(!$this->calificacionId, 404);

        if ($this->calificacionId) {
            $this->calificacion = ModeloCalificacion::find($this->calificacionId);

            $this->cargarAttendanceData(); // Cargar los datos al montar la página
        }
    }

    public function saveAttendance(): void
    {
        if (!$this->calificacion) {
            \Filament\Notifications\Notification::make()
                ->danger()
                ->title("No hay calificación cargada.")
                ->send();
            return;
        }

        foreach ($this->attendanceData as $detalleId => $data) {
            $detalle = $this->calificacion->detalles()->find($detalleId);
            if ($detalle) {
                $detalle->nota = $data['nota'] ?? 0; // Asumiendo que 'valor' es el campo para las notas
                $detalle->save();
            }
        }

        \Filament\Notifications\Notification::make()
            ->success()
            ->title("Calificaciones guardadas correctamente.")
            ->send();

        $this->cargarAttendanceData(); // Recargar los datos después de guardar
    }

    // Nuevo método para cargar los detalles en attendanceData
    public function cargarAttendanceData()
    {
        $this->attendanceData = [];

        if ($this->calificacion) {
            foreach ($this->calificacion->detalles as $detalle) {
                $this->attendanceData[$detalle->id] = [
                    'nota' => $detalle->nota,
                    // Puedes agregar más campos si los necesitas
                ];
            }
        }
    }
    public function sincronizar(): void
    {
        if ($this->calificacion && $this->calificacion->asignacion && $this->calificacion->asignacion->curso) {
            $matriculas = $this->calificacion->asignacion->curso->matriculas;
            foreach ($matriculas as $matricula) {
                $estudiante = $matricula->estudiante;
                $existeDetalle = $this->calificacion->detalles()->where('estudiante_id', $estudiante->id)->exists();
                if (!$existeDetalle) {
                    $this->calificacion->detalles()->create([
                        'estudiante_id' => $estudiante->id,
                        'nota' => 0, // O el valor por defecto que desees
                    ]);
                }
            }
        }

        \Filament\Notifications\Notification::make()
            ->success()
            ->title("Lista de calificaciones sincronizada correctamente.")
            ->send();

        $this->cargarAttendanceData();
    }
}
