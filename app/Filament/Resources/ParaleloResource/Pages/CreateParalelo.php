<?php

namespace App\Filament\Resources\ParaleloResource\Pages;

use App\Filament\Resources\ParaleloResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateParalelo extends CreateRecord
{
    protected static string $resource = ParaleloResource::class;

    protected static bool $canCreateAnother = false;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
