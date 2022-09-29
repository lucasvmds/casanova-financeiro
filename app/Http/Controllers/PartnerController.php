<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Common\DeleteOrRestoreModel;
use App\Actions\Partner\CreateNewPartner;
use App\Actions\Partner\UpdatePartner;
use App\Http\Requests\Partner\StoreUpdatePartnerRequest;
use App\Models\Partner;
use App\Models\Product;
use App\Support\FlashMessages;
use Inertia\Inertia;

class PartnerController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Partner::class, 'partner');
    }

    private function getCommonData(string $type, array $props = []): array
    {
        return [
            'partners' => Partner::withTrashed()
                ->orderBy('name')
                ->get([
                    'id',
                    'name',
                    'deleted_at',
                ]),
            'type' => $type,
            ...$props,
        ];
    }

    private function getCommonDataWithProducts(string $type, array $props = []): array
    {
        return $this->getCommonData($type, [
            'products' => Product::orderBy('name')->get([
                'id',
                'name',
            ]),
            ...$props,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Partner/Main', $this->getCommonData('index'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Partner/Main', $this->getCommonDataWithProducts('create'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreUpdatePartnerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUpdatePartnerRequest $request)
    {
        CreateNewPartner::run($request->validated());
        FlashMessages::success('Parceiro criado com sucesso');
        return redirect()->route('partners.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function edit(Partner $partner)
    {
        return Inertia::render('Partner/Main', $this->getCommonDataWithProducts('edit', [
            'partner_products' => $partner->products()->get(['products.id']),
            'partner' => $partner,
        ]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  StoreUpdatePartnerRequest  $request
     * @param  \App\Models\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUpdatePartnerRequest $request, Partner $partner)
    {
        UpdatePartner::run($request->validated(), $partner);
        FlashMessages::success('Parceiro editado com sucesso');
        return redirect()->route('partners.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function destroy(Partner $partner)
    {
        DeleteOrRestoreModel::run($partner);
        return redirect()->route('partners.index');
    }
}
