<?php

declare(strict_types=1);

namespace App\Actions\Proposal;

use App\Http\Requests\Proposal\StoreProposalRequest;
use App\Models\Proposal;
use Illuminate\Support\Facades\DB;

class CreateNewProposal
{
    private const INITIAL_STATUS = 1;
    
    public static function run(StoreProposalRequest $request): void
    {
        $data = $request->validated();
        $data['status_id'] = self::INITIAL_STATUS;
        $data['user_id'] = $request->user()->id;

        DB::transaction(function() use($data) {
            $proposal = Proposal::create($data);
            $proposal->statuses()->attach(
                self::INITIAL_STATUS,
                [ 'note' => 'Criação da proposta', ]
            );
        });
    }
}