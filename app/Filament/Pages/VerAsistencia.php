<?php

namespace App\Filament\Pages;

use Filament\Forms\Form;

use Filament\Pages\Page;
use App\Models\Asistencia as ModeloAsistencia;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;

class VerAsistencia extends Page  implements HasForms
{

    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.ver-asistencia';

    protected static bool $shouldRegisterNavigation = false;


    public ?string $fechaSeleccionada = null;
    public ?Asistencia $asistencia = null;

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            \Filament\Forms\Components\DatePicker::make('fechaSeleccionada')
                ->label('Seleccionar fecha')
                ->required()
                ->reactive()
                ->afterStateUpdated(fn($state) => $this->buscarAsistencia($state)),
        ]);
    }

    public function buscarAsistencia($fecha): void
    {
        $this->asistencia = ModeloAsistencia::where('fecha', $fecha)->first();

        \Filament\Notifications\Notification::make()
            ->success()
            ->title("buscando asistencia")
            ->send();
    }

    protected function getFormActions(): array
    {
        return [
            \Filament\Actions\Action::make('generar')
                ->label('Crear lista de asistencia')
                ->action('generar'),
        ];
    }

    public function generar(): void
    {

        \Filament\Notifications\Notification::make()
            ->success()
            ->title("generado con éxito")
            ->send();

        $this->buscarAsistencia($this->fechaSeleccionada);
    }
}
