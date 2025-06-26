<x-filament::page>
    <div class="max-w-xl space-y-4">
        {{ $this->form }}

        @if ($fechaSeleccionada)
            @if ($asistencia)
                <div class="mt-6 border p-4 rounded bg-white shadow">
                    <h2 class="text-lg font-bold mb-2">Asistencia del
                        {{ \Carbon\Carbon::parse($fechaSeleccionada)->format('d/m/Y') }}</h2>
                    <p><strong>Descripción:</strong> {{ $asistencia->descripcion ?? 'Sin descripción' }}</p>

                    <h3 class="font-semibold mt-4">Detalles:</h3>
                    <table class="table-auto w-full mt-2 border">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="border px-2 py-1">Estudiante</th>
                                <th class="border px-2 py-1">Estado</th>
                                <th class="border px-2 py-1">Observación</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($asistencia->detalles as $detalle)
                                <tr>
                                    <td class="border px-2 py-1">{{ $detalle->estudiante->nombre }}</td>
                                    <td class="border px-2 py-1">{{ $detalle->estado }}</td>
                                    <td class="border px-2 py-1">{{ $detalle->observacion }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="mt-6 p-4">
                    <p>No se encontró asistencia para la fecha seleccionada.</p>
                    <x-filament-panels::form.actions :actions="$this->getFormActions()" />
                </div>
            @endif
        @endif
    </div>
</x-filament::page>
