<script lang="ts">
    interface Product {
        id:number;
        name: string;
    }

    interface Data {
        name: string;
    }

    import { Input, Errors } from "../../Components/Form/index.svelte";
    import { page } from "@inertiajs/inertia-svelte";
    import { Inertia } from "@inertiajs/inertia";
    import { onDestroy, onMount } from "svelte";
    export let type: 'create' | 'edit';

    let
        product: Product | undefined,
        errors: Errors<Data>;

    $: {
        product = $page.props.product;
        errors = $page.props.errors;
    }

    const data: Data = {
        name: product?.name,
    }

    
    function refreshData(): void
    {
        data.name = product?.name;
    }
    onMount(refreshData);
    document.addEventListener('products:refresh', refreshData);
    onDestroy( () => document.removeEventListener('products:refresh', refreshData));



    function handleSubmit()
    {
        if (type === 'create') {
            Inertia.post('/products', data as any, { preserveScroll: true });
        } else if (type === 'edit') {
            Inertia.patch(`/products/${product.id}`, data as any, { preserveScroll: true });
        }
    }
</script>

<form id="form-products" on:submit|preventDefault={handleSubmit} class="container">
    <legend>
        {type === 'create' ? 'Novo produto' : product?.name}
    </legend>
    <Input type="text" label="Nome" bind:value={data.name} error={errors.name} size=30 required />
</form>