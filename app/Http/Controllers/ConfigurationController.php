<?php

namespace App\Http\Controllers;

use App\Actions\Configuration\UpdateConfiguration;
use App\Http\Requests\Configuration\UpdateConfigurationRequest;
use App\Models\Configuration;
use App\Models\Status;
use App\Support\FlashMessages;
use Inertia\Inertia;

class ConfigurationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Configuration/Index', [
            'statuses' => Status::withTrashed()->get([
                'id',
                'name',
                'color',
                'main',
                'deleted_at',
            ]),
            'config' => Configuration::first([
                'seller_commission',
            ]),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateConfigurationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateConfigurationRequest $request)
    {
        UpdateConfiguration::run($request->validated());
        FlashMessages::success('Configurações salvas com sucesso');
        return back();
    }
}
