<?php

namespace App\Filament\Resources\MateriaResource\Pages;

use App\Filament\Resources\MateriaResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateMateria extends CreateRecord
{
    protected static string $resource = MateriaResource::class;

    protected static bool $canCreateAnother = false;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
