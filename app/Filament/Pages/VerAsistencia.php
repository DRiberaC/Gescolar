<?php

namespace App\Filament\Pages;

use Filament\Forms\Form;
use Filament\Pages\Page;
use App\Models\Asistencia as ModeloAsistencia;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use App\Models\Asignacion as ModeloAsignacion;

class VerAsistencia extends Page implements HasForms
{
    use InteractsWithForms;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'filament.pages.ver-asistencia';
    protected static bool $shouldRegisterNavigation = false;
    protected array $queryString = [
        'asignacionId' => ['except' => null],
    ];
    public ?string $asignacionId = null;
    public ?string $fechaAsistencia = null;
    public ?ModeloAsistencia $asistencia = null;
    public ?ModeloAsignacion $asignacion = null;
    public $attendanceData = [];

    public function mount(): void
    {
        if ($this->asignacionId) {
            $this->asignacion = ModeloAsignacion::find($this->asignacionId);
        }

        if (is_null($this->fechaAsistencia)) {
            $this->fechaAsistencia = now()->format('Y-m-d');
        }

        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            \Filament\Forms\Components\DatePicker::make('fechaAsistencia')
                ->label('Seleccionar fecha')
                ->default(now())
                ->required(),
        ]);
    }

    public function buscar(): void
    {
        if (!$this->fechaAsistencia) {
            \Filament\Notifications\Notification::make()
                ->danger()
                ->title("Por favor, selecciona una fecha")
                ->send();
            return;
        }

        $existingAsistencia = ModeloAsistencia::where('fecha', $this->fechaAsistencia)
            ->where('asignacion_id', $this->asignacionId)
            ->first();

        $this->asistencia = $existingAsistencia;
        $this->cargarAttendanceData();

        \Filament\Notifications\Notification::make()
            ->success()
            ->title("Lista de asistencia cargada correctamente.")
            ->send();
    }

    public function generar(): void
    {
        if (!$this->fechaAsistencia) {
            \Filament\Notifications\Notification::make()
                ->danger()
                ->title("Por favor, selecciona una fecha")
                ->send();
            return;
        }

        $existingAsistencia = ModeloAsistencia::where('fecha', $this->fechaAsistencia)
            ->where('asignacion_id', $this->asignacionId)
            ->first();
        $this->asistencia = $existingAsistencia;

        if ($existingAsistencia) {
            $this->cargarAttendanceData();
        } else {
            $this->asistencia = ModeloAsistencia::create([
                'asignacion_id' => $this->asignacionId,
                'fecha' => $this->fechaAsistencia,
                'descripcion' => 'Asistencia generada automáticamente',
            ]);
            if ($this->asignacion && $this->asignacion->curso) {
                $matriculas = $this->asignacion->curso->matriculas;
                foreach ($matriculas as $matricula) {
                    $estudiante = $matricula->estudiante;
                    $this->asistencia->detalles()->create([
                        'estado' => 'presente',
                        'observacion' => null,
                        'estudiante_id' => $estudiante->id,
                    ]);
                }
            }
        }
    }

    public function sincronizar(): void
    {
        if ($this->asignacion && $this->asignacion->curso) {
            $matriculas = $this->asignacion->curso->matriculas;
            foreach ($matriculas as $matricula) {
                $estudiante = $matricula->estudiante;
                $existeDetalle = $this->asistencia->detalles()->where('estudiante_id', $estudiante->id)->exists();
                if (!$existeDetalle) {
                    $this->asistencia->detalles()->create([
                        'estado' => 'presente',
                        'observacion' => null,
                        'estudiante_id' => $estudiante->id,
                    ]);
                }
            }
        }

        \Filament\Notifications\Notification::make()
            ->success()
            ->title("Lista de asistencia sincronizada correctamente.")
            ->send();

        $this->cargarAttendanceData();
    }

    public function saveAttendance()
    {
        if (!$this->asistencia) {
            \Filament\Notifications\Notification::make()
                ->danger()
                ->title("No hay lista de asistencia cargada.")
                ->send();
            return;
        }

        foreach ($this->attendanceData as $detalleId => $data) {
            $detalle = $this->asistencia->detalles()->find($detalleId);
            if ($detalle) {
                $detalle->estado = $data['estado'] ?? 'presente';
                $detalle->observacion = $data['observacion'] ?? null;
                $detalle->save();
            }
        }

        \Filament\Notifications\Notification::make()
            ->success()
            ->title("Asistencia guardada correctamente.")
            ->send();
    }

    public function cargarAttendanceData()
    {
        $this->attendanceData = [];

        if ($this->asistencia) {
            foreach ($this->asistencia->detalles as $detalle) {
                $this->attendanceData[$detalle->id] = [
                    'estado' => $detalle->estado,
                    'observacion' => $detalle->observacion,
                ];
            }
        }
    }
}
