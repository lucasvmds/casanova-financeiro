<?php

declare(strict_types=1);

namespace App\Actions\Proposal;

use App\Models\Proposal;
use Illuminate\Support\Facades\DB;

class UpdateProposal
{
    private static function shouldAddStatusHistory(Proposal $proposal, array $data): bool
    {
        return isset($data['status_note']) ||
            $proposal->status_id !== $data['status_id'];
    }

    public static function run(array $data, Proposal $proposal): void
    {
        DB::transaction(function() use($data, $proposal) {
            if (self::shouldAddStatusHistory($proposal, $data)) {
                $proposal->statuses()->attach(
                    $data['status_id'],
                    ['note' => $data['status_note'] ?? 'Alteração de status'],
                );
            }

            $proposal->update([
                'status_id' => $data['status_id'],
                'required_amount' => $data['required_amount'],
                'additional_info' => $data['additional_info'],
                'partner_id' => $data['partner_id'],
                'contract_identifier' => $data['contract_identifier'],
            ]);

            if (GenerateCommissions::proposalIsApproved($proposal)) {
                GenerateCommissions::run($proposal);
            }
        });
    }
}