<?php

namespace App\Filament\Resources\WaliSantris\Pages;

use App\Filament\Resources\WaliSantris\WaliSantriResource;
use Filament\Resources\Pages\CreateRecord;

class CreateWaliSantri extends CreateRecord
{
    protected static string $resource = WaliSantriResource::class;

    protected array $santriRelations = [];

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $this->santriRelations = $data['santriRelations'] ?? [];
        unset($data['santriRelations']);

        return $data;
    }

    protected function afterCreate(): void
    {
        foreach ($this->santriRelations as $item) {
            if (!empty($item['id']) && !empty($item['relation'])) {

                // Cek ulang sebelum attach — jaga-jaga race condition
                $alreadyTaken = \DB::table('wali_santri_santri')
                    ->where('santri_id', $item['id'])
                    ->exists();

                if ($alreadyTaken) {
                    \Filament\Notifications\Notification::make()
                        ->title('Sebagian santri gagal ditambahkan')
                        ->body('Santri tersebut sudah terhubung dengan wali lain.')
                        ->warning()
                        ->send();
                    continue;
                }

                $this->record->santris()->attach($item['id'], [
                    'relation' => $item['relation'],
                ]);
            }
        }
    }
}