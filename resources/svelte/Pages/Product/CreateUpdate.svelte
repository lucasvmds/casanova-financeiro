<script lang="ts">
    interface Partner {
        id:number;
        name: string;
    }

    interface Product extends Partner {
        commission: number;
    }

    interface Data {
        name: string;
        partners: number[];
        commission: number;
    }

    import { Input, SelectionBox, Errors, Error } from "../../Components/Form/index.svelte";
    import { page } from "@inertiajs/inertia-svelte";
    import { Inertia } from "@inertiajs/inertia";
    import { onDestroy, onMount } from "svelte";
    export let type: 'create' | 'edit';

    let
        product: Product | undefined,
        product_partners: number[],
        partners: Partner[],
        errors: Errors<Data>;

    $: {
        product = $page.props.product;
        product_partners = $page.props.product_partners || [];
        partners = $page.props.partners || [];
        errors = $page.props.errors;
    }

    const data: Data = {
        name: product?.name,
        partners: product_partners,
        commission: product?.commission,
    }

    
    function refreshData(): void
    {
        data.name = product?.name;
        data.commission = product?.commission;
        data.partners = product_partners;
    }
    onMount(refreshData);
    document.addEventListener('custom:refresh', refreshData);
    onDestroy( () => document.removeEventListener('custom:refresh', refreshData));



    function handleSubmit()
    {
        if (type === 'create') {
            Inertia.post('/products', data as any, { preserveScroll: true });
        } else if (type === 'edit') {
            Inertia.patch(`/products/${product.id}`, data as any, { preserveScroll: true });
        }
    }
</script>

<div class="container">
    <form id="form-products" on:submit|preventDefault={handleSubmit}>
        <Input type="text" label="Nome" bind:value={data.name} error={errors.name} size=30 required />
        <br />
        <Input type="number" label="Comissão" bind:value={data.commission} error={errors.commission} max=100 required />
        <fieldset>
            <legend>Parceiros</legend>
            <Error error={errors.partners} />

            {#each partners as partner, index}
                <SelectionBox type="checkgroup" label={partner.name} bind:group={data.partners} value={partner.id} error={errors[`partners.${index}`]} />
                <br />
            {:else}
                Vocẽ não possui parceiros cadastrados
            {/each}
        </fieldset>
    </form>
</div>