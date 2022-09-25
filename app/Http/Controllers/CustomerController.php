<?php

namespace App\Http\Controllers;

use App\Actions\Customer\CreateNewCustomer;
use App\Actions\Customer\PaginateCustomerRecords;
use App\Actions\Customer\UpdateCustomer;
use App\Http\Requests\Customer\IndexCustomerRequest;
use App\Http\Requests\Customer\StoreUpdateCustomerRequest;
use App\Models\Customer;
use App\Models\State;
use App\Support\FlashMessages;
use Inertia\Inertia;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Customer::class, 'customer');
    }

    /**
     * Retorna os estados
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function getStates()
    {
        return State::orderBy('name')->get(['id', 'name']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(IndexCustomerRequest $request)
    {
        if ($customers = PaginateCustomerRecords::run($request)) {
            return Inertia::render('Customer/Index', [
                'customers' => $customers
            ]);
        } else {
            return redirect()->route('customers.index',['items' => $request->validated('items')]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Customer/CreateEdit', [
            'states' => $this->getStates(),
            'type' => 'create',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreUpdateCustomerRequest $request 
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUpdateCustomerRequest $request)
    {
        CreateNewCustomer::run($request->validated());
        FlashMessages::success('Cliente cadastrado com sucesso');
        return redirect()->route('customers.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        return Inertia::render('Customer/CreateEdit', [
            'customer' => $customer,
            'contacts' => $customer->contacts()->get([
                'id',
                'name',
                'phone',
                'email',
            ]),
            'states' => $this->getStates(),
            'type' => 'edit',
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  StoreUpdateCustomerRequest  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUpdateCustomerRequest $request, Customer $customer)
    {
        UpdateCustomer::run($request->validated(), $customer);
        FlashMessages::success('Cliente cadastrado com sucesso');
        return redirect()->route('customers.index');
    }

    /**
     * @param State $state
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function cities(State $state)
    {
        return $state->cities()->get(['id', 'name']);
    }
}
