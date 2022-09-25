<script lang="ts">
    interface Partner {
        id:number;
        name: string;
    }

    type Product = Partner;

    interface Data {
        name: string;
        products: number[];
    }

    import { Input, SelectionBox, Errors, Error } from "../../Components/Form/index.svelte";
    import { page } from "@inertiajs/inertia-svelte";
    import { Inertia } from "@inertiajs/inertia";
    import { onDestroy, onMount } from "svelte";
    export let type: 'create' | 'edit';

    let
        partner: Partner | undefined,
        partner_products: number[],
        products: Product[],
        errors: Errors<Data>;

    $: {
        partner = $page.props.partner;
        partner_products = $page.props.partner_products || [];
        products = $page.props.products || [];
        errors = $page.props.errors;
    }

    const data: Data = {
        name: partner?.name,
        products: partner_products,
    }

    
    function refreshData(): void
    {
        data.name = partner?.name;
        data.products = partner_products;
    }
    onMount(refreshData);
    document.addEventListener('custom:refresh', refreshData);
    onDestroy( () => document.removeEventListener('custom:refresh', refreshData));



    function handleSubmit()
    {
        if (type === 'create') {
            Inertia.post('/partners', data as any, { preserveScroll: true });
        } else if (type === 'edit') {
            Inertia.patch(`/partners/${partner.id}`, data as any, { preserveScroll: true });
        }
    }
</script>

<div class="container">
    <form id="form-partners" on:submit|preventDefault={handleSubmit}>
        <Input type="text" label="Nome" bind:value={data.name} error={errors.name} size=30 required />
        <fieldset>
            <legend>Produtos</legend>
            <Error error={errors.products} />

            {#each products as product, index}
                <SelectionBox type="checkgroup" label={product.name} bind:group={data.products} value={product.id} error={errors[`products.${index}`]} />
                <br />
            {:else}
                Vocẽ não possui produtos cadastrados
            {/each}
        </fieldset>
    </form>
</div>