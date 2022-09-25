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
                title = 'Parceiros'
                break;
            case 'create':
                title = 'Adicionar parceiro';
                break;
            case 'edit':
                title = 'Editar parceiro';
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
        <Link href="/partners/create">
            Adicionar parceiro
        </Link>
    {:else}
        <Button type="submit" form="form-partners">
            Salvar
        </Button>
        <Link href="/partners">
            Fechar
        </Link>
    {/if}
</aside>