<?php

namespace App\Filament\Resources\PersonalResource\Pages;

use App\Models\User;
use Filament\Actions;
use Illuminate\Support\Str;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\PersonalResource;

class CreatePersonal extends CreateRecord
{
    protected static string $resource = PersonalResource::class;

    protected static bool $canCreateAnother = false;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (empty($data['correo_electronico'])) {
            $correoGenerado = Str::slug($data['nombre'] . '.' . $data['ap_paterno']) . '@email.com';
            $data['correo_electronico'] = $correoGenerado;
        }

        $user = User::create([
            'name' => $data['nombre'] . ' ' . $data['ap_paterno'],
            'email' => $data['correo_electronico'],
            'password' => bcrypt($data['ap_paterno'] . $data['ci'])
        ]);

        // Asignar el ID del usuario al dato del formulario
        $data['user_id'] = $user->id;

        return $data;
    }
}
