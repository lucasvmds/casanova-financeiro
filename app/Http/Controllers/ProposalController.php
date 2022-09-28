<?php

namespace App\Http\Controllers;

use App\Actions\Proposal\CreateNewProposal;
use App\Actions\Proposal\PaginateProposalRecords;
use App\Http\Requests\Proposal\IndexProposalRequest;
use App\Http\Requests\Proposal\StoreProposalRequest;
use App\Http\Requests\Proposal\UpdateProposalRequest;
use App\Models\Product;
use App\Models\Proposal;
use App\Models\Status;
use App\Support\FlashMessages;
use Illuminate\Support\Collection;
use Inertia\Inertia;

class ProposalController extends Controller
{
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
            'products' => Product::orderBy('name')->get(['id', 'name']),
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
     * Display the specified resource.
     *
     * @param  \App\Models\Proposal  $proposal
     * @return \Illuminate\Http\Response
     */
    public function show(Proposal $proposal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Proposal  $proposal
     * @return \Illuminate\Http\Response
     */
    public function edit(Proposal $proposal)
    {
        return Inertia::render('Proposal/Edit/Main', [
            'proposal' => $proposal,
            'statuses' => Status::orderBy('name')->get([
                'id',
                'name',
                'color',
            ]),
            'proposal_statuses' => $this->getProposalStatuses($proposal),
            'partners' => Product::find($proposal->product_id)->partners()->orderBy('name')->get(['partners.id', 'partners.name']),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Proposal  $proposal
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProposalRequest $request, Proposal $proposal)
    {
        FlashMessages::success('Proposta editada com sucesso');
        return redirect()->route('proposals.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Proposal  $proposal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Proposal $proposal)
    {
        //
    }

    private function getProposalStatuses(Proposal $proposal): Collection
    {
        return $proposal->statuses()
            ->withTrashed()
            ->orderByPivot('created_at', 'desc')
            ->get(['name', 'color']);
    }
}
