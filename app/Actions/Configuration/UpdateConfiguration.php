<?php

declare(strict_types=1);

namespace App\Actions\Configuration;

use App\Models\Configuration;
use App\Models\Status;
use Illuminate\Support\Facades\DB;

class UpdateConfiguration
{
    public static function run(array $data): void
    {
        DB::transaction(function() use($data) {
            Configuration::first()->update([
                'seller_commission' => $data['seller_commission'],
            ]);

            foreach ($data['statuses'] as $status) {
                $status_data = [
                    'name' => $status['name'],
                    'color' => $status['color'],
                    'deleted_at' => $status['active'] ? NULL : now(),
                ];

                if (isset($status['id'])) {
                    // Os IDs < 4 são os status padrões do sistema,
                    // não podendo ser feitas certas modificações neles
                    if ($status['id'] <= 3) {
                        unset(
                            $status_data['deleted_at'],
                            $status_data['name'],
                        );
                    }

                    Status::withTrashed()
                        ->find($status['id'])
                        ->update($status_data);
                } else {
                    $status_data['main'] = $status['main'];
                    Status::create($status_data);
                }
            }
        });
    }
}