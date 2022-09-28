<script lang="ts">
    interface Partner {
        id:number;
        name: string;
    }

    type Product = Partner;

    interface PartnerProduct {
        id: number;
        pivot: {
            commission: number;
        }
    }

    interface Data {
        name: string;
        products: number[];
        commissions: { [key: number]: number };
    }

    import { Input, SelectionBox, Errors, Error } from "../../Components/Form/index.svelte";
    import { page } from "@inertiajs/inertia-svelte";
    import { Inertia } from "@inertiajs/inertia";
    import { onDestroy, onMount } from "svelte";
    export let type: 'create' | 'edit';

    let
        partner: Partner | undefined,
        partner_products: PartnerProduct[],
        products: Product[],
        errors: Errors<Data>;

    $: {
        partner = $page.props.partner;
        partner_products = $page.props.partner_products || [];
        products = $page.props.products || [];
        errors = $page.props.errors;
    }

    function handlePartnerProducts(partnerProducts: PartnerProduct[] = []): Data['commissions']
    {
        const items: Data['commissions'] = {};
        for (const item of partnerProducts) {
            items[ item.id ] = item.pivot.commission;
        }

        return items;
    }

    const data: Data = {
        name: partner?.name,
        products: partner_products?.map(item => item.id),
        commissions: handlePartnerProducts(partner_products),
    }

    function refreshData(): void
    {
        data.name = partner?.name;
        data.products = partner_products?.map(item => item.id);
        data.commissions = handlePartnerProducts(partner_products);
    }
    onMount( () => {
        refreshData();
        document.addEventListener('custom:refresh', refreshData);
    });
    onDestroy( () => document.removeEventListener('custom:refresh', refreshData));

    function handleSubmit()
    {
        const temp = {...data};
        const prod: { [key: number]: number; } = {};
        temp.products.forEach(item => prod[item] = item);
        temp.products = prod as any;

        if (type === 'create') {
            Inertia.post('/partners', temp as any, { preserveScroll: true });
        } else if (type === 'edit') {
            Inertia.patch(`/partners/${partner.id}`, temp as any, { preserveScroll: true });
        }
    }
</script>

<div class="container">
    <form id="form-partners" on:submit|preventDefault={handleSubmit}>
        <legend>
            {type === 'create' ? 'Novo parceiro' : partner?.name}
        </legend>
        <Input type="text" label="Nome" bind:value={data.name} error={errors.name} size=30 required />
        <fieldset>
            <legend>Produtos</legend>
            <Error error={errors.products} />

            {#each products as product}
                <SelectionBox type="checkgroup" label={product.name} bind:group={data.products} value={product.id} error={errors[`products.${product.id}`]} />
                <Input type="number" max=100 min=0 label="Comissão" bind:value={data.commissions[product.id]} error={errors[`commissions.${product.id}`]} />
                <br />
            {:else}
                Vocẽ não possui produtos cadastrados
            {/each}
        </fieldset>
    </form>
</div>