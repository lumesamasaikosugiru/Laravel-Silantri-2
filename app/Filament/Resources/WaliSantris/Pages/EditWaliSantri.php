<?php

namespace App\Filament\Resources\WaliSantris\Pages;

use App\Filament\Resources\WaliSantris\WaliSantriResource;
use Filament\Resources\Pages\EditRecord;

class EditWaliSantri extends EditRecord
{
    protected static string $resource = WaliSantriResource::class;

    protected array $santriRelations = [];

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Load data existing relasi ke format Repeater
        $data['santriRelations'] = $this->record->santris->map(function ($santri) {
            return [
                'id' => $santri->id,
                'relation' => $santri->pivot->relation,
            ];
        })->toArray();

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $this->santriRelations = $data['santriRelations'] ?? [];
        unset($data['santriRelations']);

        return $data;
    }

    protected function afterSave(): void
    {
        $syncData = [];

        foreach ($this->santriRelations as $item) {
            if (!empty($item['id']) && !empty($item['relation'])) {

                $alreadyTaken = \DB::table('wali_santri_santri')
                    ->where('santri_id', $item['id'])
                    ->where('wali_santri_id', '!=', $this->record->id) // exclude diri sendiri
                    ->exists();

                if ($alreadyTaken) {
                    \Filament\Notifications\Notification::make()
                        ->title('Sebagian santri gagal disimpan')
                        ->body('Santri tersebut sudah terhubung dengan wali lain.')
                        ->warning()
                        ->send();
                    continue;
                }

                $syncData[$item['id']] = ['relation' => $item['relation']];
            }
        }

        $this->record->santris()->sync($syncData);
    }
}