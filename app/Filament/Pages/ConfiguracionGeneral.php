<?php

namespace App\Filament\Pages;

use Filament\Forms\Form;
use Filament\Pages\Page;
use App\Models\Configuracion;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Actions\Action;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Support\Exceptions\Halt;
use Filament\Notifications\Notification;

class ConfiguracionGeneral extends Page implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static string $view = 'filament.pages.configuracion-general';

    public ?Configuracion $config;

    public function mount(): void
    {
        $this->config = Configuracion::first();

        if ($this->config === null) {
            // Si no existe un registro, crear uno nuevo
            $this->config = new Configuracion();
        }

        $this->form->fill($this->config->toArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()->schema([
                    TextInput::make('nombre')->required()->label('Nombre'),
                    TextInput::make('direccion')->label('Dirección'),
                    TextInput::make('telefono')->label('Teléfono'),
                    TextInput::make('correo_electronico')->email()->label('Correo Electrónico'),
                    Textarea::make('descripcion')->label('Descripción'),
                ])->columns([
                    'sm' => 2,
                    'xl' => 2,
                    '2xl' => 2,
                ])
            ])
            ->statePath('data');
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Guardar')
                ->submit('save'),
        ];
    }

    public function save(): void
    {
        try {
            $data = $this->form->getState();

            $this->config->update($data);
        } catch (Halt $exception) {
            return;
        }

        Notification::make()
            ->success()
            ->title('Configuración actualizada con éxito')
            ->send();
    }
}
