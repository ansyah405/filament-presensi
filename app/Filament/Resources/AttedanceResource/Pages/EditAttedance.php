<?php

namespace App\Filament\Resources\AttedanceResource\Pages;

use App\Filament\Resources\AttedanceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAttedance extends EditRecord
{
    protected static string $resource = AttedanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
