<?php

namespace App\Http\Controllers;

use App\Actions\Proposal\ControllerData\GetPartners;
use App\Actions\Proposal\ControllerData\GetProposalStatuses;
use App\Actions\Proposal\ControllerData\GetStatuses;
use App\Actions\Proposal\CreateNewProposal;
use App\Actions\Proposal\PaginateProposalRecords;
use App\Actions\Proposal\ProposalIsEditable;
use App\Actions\Proposal\UpdateProposal;
use App\Http\Requests\Proposal\IndexProposalRequest;
use App\Http\Requests\Proposal\StoreProposalRequest;
use App\Http\Requests\Proposal\UpdateProposalRequest;
use App\Models\Product;
use App\Models\Proposal;
use App\Support\FlashMessages;
use Inertia\Inertia;

class ProposalController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Proposal::class, 'proposal');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(IndexProposalRequest $request)
    {
        if ($proposals = PaginateProposalRecords::run($request)) {
            return Inertia::render('Proposal/Index', [
                'proposals' => $proposals
            ]);
        } else {
            return redirect()->route('proposals.index',['items' => $request->validated('items')]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Proposal/Create/Main', [
            'products' => Product::orderBy('name')->get(['id', 'name'])->filter(
                fn($value) => (bool) $value->partners()->count()
            ),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProposalRequest $request)
    {
        CreateNewProposal::run($request);
        FlashMessages::success('Proposta salva com sucesso');
        return redirect()->route('proposals.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Proposal  $proposal
     * @return \Illuminate\Http\Response
     */
    public function edit(Proposal $proposal)
    {
        if (! ProposalIsEditable::run($proposal)) {
            FlashMessages::shareNow()
                ->warning('A proposta já está fechada ou aprovada, não podendo mais ser editada');
        }

        return Inertia::render('Proposal/Edit/Main', [
            'proposal' => $proposal,
            'statuses' => GetStatuses::get($proposal),
            'proposal_statuses' => GetProposalStatuses::get($proposal),
            'partners' => GetPartners::get($proposal),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProposalRequest $request, Proposal $proposal)
    {
        if (! ProposalIsEditable::run($proposal)) return back();

        UpdateProposal::run($request->validated(), $proposal);
        FlashMessages::success('Proposta editada com sucesso');
        return redirect()->route('proposals.index');
    }
}
