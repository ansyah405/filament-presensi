<?php

namespace App\Filament\Resources\AttedanceResource\Pages;

use App\Filament\Resources\AttedanceResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;

class ListAttedances extends ListRecords
{
    protected static string $resource = AttedanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('Download Data')
                ->url(route('attendanceExport'))
                ->color('danger'),
            Action::make('Presensi')
                ->url(route('presensi'))
                ->color('warning'),
            Actions\CreateAction::make(),
        ];
    }
}
