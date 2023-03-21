<?php

namespace SolutionForest\FilamentAccessManagement\Resources\PermissionResource\Pages;

use SolutionForest\FilamentAccessManagement\Resources\PermissionResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPermission extends EditRecord
{
    protected static string $resource = PermissionResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
