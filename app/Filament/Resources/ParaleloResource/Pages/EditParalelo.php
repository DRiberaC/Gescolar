<?php

namespace App\Filament\Resources\ParaleloResource\Pages;

use App\Filament\Resources\ParaleloResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditParalelo extends EditRecord
{
    protected static string $resource = ParaleloResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
