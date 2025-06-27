<x-filament::page>
    @if ($asignacion)
        <div class="p-4 mb-4 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <h2 class="text-xl font-bold tracking-tight text-gray-900 dark:text-white">
                Asistencia para: {{ $asignacion->curso->nombre }}
            </h2>
            <p class="text-gray-500 dark:text-gray-400">
                Materia:{{ $asignacion->materia->nombre }} | Gestión: {{ $asignacion->gestion->nombre }}
            </p>
        </div>
    @endif
    <div class="space-y-4 w-full">
        <div class="flex items-end gap-2">
            {{ $this->form }}
            <x-filament::button wire:click="buscar">
                Cargar Lista
            </x-filament::button>
        </div>

        @if ($fechaAsistencia)
            @if ($asistencia)
                <div class="mt-6 border p-4 rounded bg-white shadow">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-bold">Asistencia del
                            {{ \Carbon\Carbon::parse($fechaAsistencia)->format('d/m/Y') }}</h2>
                        <x-filament::button wire:click="sincronizar">
                            Sincronizar lista
                        </x-filament::button>
                    </div>
                    <p><strong>Descripción:</strong> {{ $asistencia->descripcion ?? 'Sin descripción' }}</p>
                    <h3 class="font-semibold mt-4">Estudiantes:</h3>
                    {{-- La tabla se convierte en un formulario --}}
                    <form wire:submit.prevent="saveAttendance">
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
                                        <td class="border px-2 py-1">
                                            <div class="flex flex-col space-y-1">
                                                <label class="inline-flex items-center">
                                                    <input type="radio" class="form-radio text-blue-600"
                                                        name="attendanceData[{{ $detalle->id }}][estado]"
                                                        value="presente"
                                                        wire:model="attendanceData.{{ $detalle->id }}.estado">
                                                    <span class="ml-2 text-sm text-gray-700">Presente</span>
                                                </label>
                                                <label class="inline-flex items-center">
                                                    <input type="radio" class="form-radio text-red-600"
                                                        name="attendanceData[{{ $detalle->id }}][estado]"
                                                        value="falta"
                                                        wire:model="attendanceData.{{ $detalle->id }}.estado">
                                                    <span class="ml-2 text-sm text-gray-700">Falta</span>
                                                </label>
                                                <label class="inline-flex items-center">
                                                    <input type="radio" class="form-radio text-yellow-600"
                                                        name="attendanceData[{{ $detalle->id }}][estado]"
                                                        value="licencia"
                                                        wire:model="attendanceData.{{ $detalle->id }}.estado">
                                                    <span class="ml-2 text-sm text-gray-700">Licencia</span>
                                                </label>
                                                <label class="inline-flex items-center">
                                                    <input type="radio" class="form-radio text-gray-600"
                                                        name="attendanceData[{{ $detalle->id }}][estado]"
                                                        value="n/a"
                                                        wire:model="attendanceData.{{ $detalle->id }}.estado">
                                                    <span class="ml-2 text-sm text-gray-700">Nada</span>
                                                </label>
                                            </div>
                                        </td>
                                        <td class="border px-2 py-1">
                                            <textarea
                                                class="w-full rounded-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                                wire:model="attendanceData.{{ $detalle->id }}.observacion" rows="1"></textarea>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="border px-2 py-1 text-center">
                                        <x-filament::button type="submit">
                                            Guardar Asistencia
                                        </x-filament::button>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </form>
                </div>
            @else
                <div class="mt-6 p-4 flex justify-center">
                    <x-filament::button wire:click="generar">
                        Generar Lista
                    </x-filament::button>
                </div>
            @endif
        @endif
    </div>
</x-filament::page>
