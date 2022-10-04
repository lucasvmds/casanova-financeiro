<script lang="ts">
    interface Data {
        customer_id: number;
        product_id: number;
        required_amount: number;
        additional_info?: string;
    }

    interface Product {
        id: number;
        name: string;
    }

    import { Button, Errors, Error, Input, Select, TextArea } from "../../../Components/Form/index.svelte";
    import { openModal } from "../../../Base/Modal.svelte";
    import { Link } from "@inertiajs/inertia-svelte";
    import { onMount, onDestroy } from "svelte";
    import CustomerSearch from "./CustomerSearch.svelte";
    import CustomerInfo from "../Common/CustomerInfo.svelte";
    import { Inertia } from "@inertiajs/inertia";
    export let
        errors: Errors<Data>,
        products: Product[];

    const data: Data = {
        customer_id: null,
        product_id: undefined,
        required_amount: null,
        additional_info: null,
    }

    function openSearchCustomerModal(): void
    {
        openModal({ component: CustomerSearch });
    }

    function handleSelectedCustomer(event: CustomEvent<{ id: number; }>): void
    {
        data.customer_id = event.detail.id;
        errors.customer_id = null;
    }

    onMount(
        () => document.addEventListener('proposal:customerselected', handleSelectedCustomer)
    );
    onDestroy(
        () => document.removeEventListener('proposal:customerselected', handleSelectedCustomer)
    );

    function handleSubmit(): void
    {
        Inertia.post('/proposals', data as any, { preserveScroll: true });
    }
</script>

<svelte:head>
    <title>Criar proposta</title>
</svelte:head>

<main>
    <form id="form-store-proposal" on:submit|preventDefault={handleSubmit} class="container">
        <fieldset>
            <legend>Cliente</legend>
            {#if data.customer_id}
                <CustomerInfo id={data.customer_id} />
            {:else}
                Cliente não selecionado
            {/if}
            <Error error={errors.customer_id} />
        </fieldset>
        <fieldset>
            <legend>Produto</legend>
            <Select label="Produto" bind:value={data.product_id} error={errors.product_id} blank required>
                {#each products as product}
                    <option value={product.id}>{product.name}</option>
                {/each}
            </Select>
            <Input type="number" label="Valor requerido (R$)" bind:value={data.required_amount} error={errors.required_amount} min=0 required step="0.01" />
        </fieldset>
        <fieldset>
            <legend>Informações adicionais</legend>
            <TextArea label="" bind:value={data.additional_info} error={errors.additional_info} cols=60 rows=10 />
        </fieldset>
    </form>
</main>

<aside>
    <Button type="submit" form="form-store-proposal">
        Salvar
    </Button>
    <Button type="button" on:click={openSearchCustomerModal}>
        Buscar cliente
    </Button>
    <Link href="/proposals">
        Voltar
    </Link>
</aside>