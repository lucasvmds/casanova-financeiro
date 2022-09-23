<script lang="ts" context="module">
    export interface Data {
        state_id: string;
        city_id: string;
        name: string;
        cpf: string;
        rg: string;
        birth_date: string;
        street: string;
        number: string;
        district: string;
        complement?: string;
        cep: string;
        additional_info?: string;
        contacts: ContactData[];
    }
</script>

<script lang="ts">
    interface StateAndCity {
        id:number;
        name: string;
    }

    interface Customer extends Data {
        id: number;
    }

    import { Button, Input, Select, Errors, Error } from "../../Components/Form/index.svelte";
    import { Inertia } from "@inertiajs/inertia";
    import { Link } from "@inertiajs/inertia-svelte";
    import Contact, { ContactData } from "./Contact.svelte";
    import { onMount } from "svelte";
    export let
        type: 'create' | 'edit',
        errors: Errors<Data>,
        states: StateAndCity[],
        customer: Customer | undefined = undefined,
        contacts: ContactData[] | undefined = undefined;


    const data: Data = {
        state_id: customer?.state_id || '',
        city_id: customer?.city_id || '',
        name: customer?.name || '',
        cpf: customer?.cpf || '',
        rg: customer?.rg || '',
        birth_date: customer?.birth_date || '',
        street: customer?.street || '',
        number: customer?.number || '',
        district: customer?.district || '',
        complement: customer?.complement || '',
        cep: customer?.cep || '',
        additional_info: customer?.additional_info || '',
        contacts: contacts || [],
    };

    let cities: StateAndCity[] = [];

    async function loadCities(): Promise<StateAndCity[]>
    {
        data.city_id = '';
        cities = [];
        if (data.state_id) {
            return fetch(`/cities/${data.state_id}`)
                .then(response => response.json())
                .then(json => cities = json)
        }
    }

    function initialLoadCities(): void
    {
        if (type === 'edit') {
            loadCities()
                .then(() => data.city_id = customer.city_id);
        }
    }
    onMount(initialLoadCities);

    function handleSubmit(): void
    {
        if (type === 'create') {
            Inertia.post('/customers', data as any);
        }
        if (type === 'edit') {
            Inertia.patch(`/customers/${customer.id}`, data as any);
        }
    }

    function addContactFields(): void
    {
        data.contacts.push({
            name: '',
            phone: '',
            email: '',
        });
        data.contacts = data.contacts;
    }
</script>

<svelte:head>
    <title>{type === 'create' ? 'Adicionar' : 'Editar'} Cliente</title>
</svelte:head>

<main>
    <div class="container">
        <form on:submit|preventDefault={handleSubmit} id="form-customer">
            <fieldset>
                <legend>Dados Pessoais</legend>
                <Input type="text" label="Nome completo" required bind:value={data.name} error={errors.name} size=60 />
                <br />
                <Input type="date" label="Data de nascimento" required bind:value={data.birth_date} error={errors.birth_date} />
                <Input type="number" label="CPF" required bind:value={data.cpf} error={errors.cpf} size=15 />
                <Input type="text" label="RG" required bind:value={data.rg} error={errors.rg} size=15 />
            </fieldset>
            <fieldset>
                <legend>Endereço</legend>
                <Input type="text" label="Rua" required bind:value={data.street} error={errors.street} size=60 />
                <Input type="text" label="Número" required bind:value={data.number} error={errors.number} size=8 />
                <br />
                <Input type="text" label="Bairro" required bind:value={data.district} error={errors.district} size=30 />
                <Input type="text" label="Complemento" bind:value={data.complement} error={errors.complement} size=40 />
                <br />
                <Input type="number" label="CEP" required bind:value={data.cep} error={errors.cep} />
                <Select label="Estado" blank bind:value={data.state_id} error={errors.state_id} required on:change={loadCities}>
                    {#each states as state}
                        <option value={state.id}>{state.name}</option>
                    {/each}
                </Select>
                <Select label="Cidade" id="city-selector" blank bind:value={data.city_id} error={errors.city_id} required>
                    {#each cities as city}
                        <option value={city.id}>{city.name}</option>
                    {/each}
                </Select>
            </fieldset>
            <fieldset>
                <legend>Contatos</legend>
                <Button type="button" on:click={addContactFields}>
                    Adicionar contato
                </Button>
                <Error error={errors.contacts} />
                {#each data.contacts as contact, index}
                    <Contact bind:contacts={data.contacts} {errors} {index} />
                {/each}
            </fieldset>
        </form>
    </div>
</main>

<aisde>
    <Button type="submit" form="form-customer">
        Salvar
    </Button>
    
    <Link href="/customers">
        Voltar
    </Link>
</aisde>
