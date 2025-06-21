<?php

namespace App\Filament\Resources\ParaleloResource\Pages;

use App\Filament\Resources\ParaleloResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListParalelos extends ListRecords
{
    protected static string $resource = ParaleloResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
