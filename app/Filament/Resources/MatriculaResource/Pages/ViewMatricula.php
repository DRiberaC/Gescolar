<?php

namespace App\Filament\Resources\MatriculaResource\Pages;

use App\Filament\Resources\MatriculaResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
// use Filament\Notifications\Notification;

class ViewMatricula extends ViewRecord
{
    protected static string $resource = MatriculaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\Action::make('generar_pdf')
                ->label('Generar PDF')
                ->icon('heroicon-o-document-text')
                ->url(fn() => route('reporte.pdf.matricula', ['id' => $this->record->id]))
                ->openUrlInNewTab()
                ->color('primary'),

            // Acción para registrar pago
            Actions\Action::make('registrar_pago')
                ->label('Registrar Pago')
                ->icon('heroicon-o-currency-dollar')
                ->color('success')
                ->size(\Filament\Support\Enums\ActionSize::Large)
                ->form([
                    \Filament\Forms\Components\TextInput::make('monto')
                        ->label('Monto')
                        ->required()
                        ->numeric()
                        ->minValue(1),

                    \Filament\Forms\Components\Select::make('metodo')
                        ->label('Método de Pago')
                        ->options([
                            'efectivo' => 'Efectivo',
                            'qr' => 'QR',
                            'tarjeta' => 'Tarjeta',
                            'transferencia' => 'Transferencia',
                            'otro' => 'Otro',
                        ])
                        ->default('efectivo')
                        ->required(),

                    \Filament\Forms\Components\DatePicker::make('fecha')
                        ->label('Fecha del Pago')
                        ->default(now())
                        ->required(),

                    \Filament\Forms\Components\Textarea::make('descripcion')
                        ->label('Descripción')
                        ->rows(2)
                        ->maxLength(255),

                    \Filament\Forms\Components\Select::make('estado')
                        ->label('Estado')
                        ->options([
                            'pendiente' => 'Pendiente',
                            'realizado' => 'Realizado',
                            'anulado' => 'Anulado',
                        ])
                        ->default('realizado'),
                ])
                ->action(function (array $data) {
                    $this->record->pagos()->create($data);
                    \Filament\Notifications\Notification::make()
                        ->title('Pago registrado correctamente.')
                        ->success()
                        ->send();
                    // return redirect(request()->header('Referer'));
                }),
        ];
    }
}
