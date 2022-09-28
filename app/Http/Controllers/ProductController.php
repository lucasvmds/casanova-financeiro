<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Common\DeleteOrRestoreModel;
use App\Http\Requests\Product\StoreUpdateProductRequest;
use App\Models\Product;
use App\Support\FlashMessages;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Product::class, 'product');
    }

    private function getCommonData(string $type, array $props = []): array
    {
        return [
            'products' => Product::withTrashed()->get([
                'id',
                'name',
                'deleted_at',
            ]),
            'type' => $type,
            ...$props,
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Product/Main', $this->getCommonData('index'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Product/Main', $this->getCommonData('create'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreUpdateProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUpdateProductRequest $request)
    {
        Product::create($request->validated());
        FlashMessages::success('Produto criado com sucesso');
        return redirect()->route('products.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return Inertia::render('Product/Main', $this->getCommonData('edit', [
            'product' => $product,
        ]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  StoreUpdateProductRequest  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUpdateProductRequest $request, Product $product)
    {
        $product->update($request->validated());
        FlashMessages::success('Produto editado com sucesso');
        return redirect()->route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        DeleteOrRestoreModel::run($product);
        return redirect()->route('products.index');
    }
}
