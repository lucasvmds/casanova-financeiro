<script lang="ts">
    import { Link } from "@inertiajs/inertia-svelte";
    import { Button } from "../../Components/Form/index.svelte";
    import Index from "./Index.svelte";
    import CreateUpdate from "./CreateUpdate.svelte";
    export let type: 'index' | 'create' | 'edit';

    let title: string;

    $: {
        switch(type) {
            case 'index':
                title = 'Produtos'
                break;
            case 'create':
                title = 'Adicionar produto';
                break;
            case 'edit':
                title = 'Editar produto';
                break;
        }
    }
</script>

<svelte:head>
    <title>{title}</title>
</svelte:head>

<main>
    <Index />

    {#if type !== 'index'}
        <CreateUpdate {type} />
    {/if}
</main>

<aside>
    {#if type === 'index'}
        <Link href="/products/create">
            Adicionar produto
        </Link>
    {:else}
        <Button type="submit" form="form-products">
            Salvar
        </Button>
        <Link href="/products">
            Fechar
        </Link>
    {/if}
</aside>