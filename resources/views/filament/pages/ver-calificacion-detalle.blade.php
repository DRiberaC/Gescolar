<x-filament-panels::page>
    @if ($calificacion)
        <div class="mt-6 border p-4 rounded bg-white shadow">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-bold">Calificación del
                    {{ \Carbon\Carbon::parse($calificacion->fecha)->format('d/m/Y') }}</h2>
                <x-filament::button wire:click="sincronizar">
                    Sincronizar lista
                </x-filament::button>
            </div>
            <p><strong>Descripción:</strong> {{ $calificacion->descripcion ?? 'Sin descripción' }}</p>
            <h3 class="font-semibold mt-4">Estudiantes:</h3>
            <form wire:submit.prevent="saveAttendance">
                <table class="table-auto w-full mt-2 border">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border px-2 py-1">Estudiante</th>
                            <th class="border px-2 py-1">Nota</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($calificacion->detalles as $detalle)
                            <tr>
                                <td class="border px-2 py-1">{{ $detalle->estudiante->nombre }}</td>
                                <td class="border px-2 py-1">
                                    <input type="text" wire:model="attendanceData.{{ $detalle->id }}.nota"
                                        class="w-full rounded-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="border px-2 py-1 text-center">
                                <x-filament::button type="submit">
                                    Guardar Calificación
                                </x-filament::button>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </form>
        </div>


    @endif
</x-filament-panels::page>
