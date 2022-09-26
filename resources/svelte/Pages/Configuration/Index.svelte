<script lang="ts" context="module">
    export interface Data {
        seller_commission: number;
        statuses: Status[];
    }
</script>

<script lang="ts">
    interface Configuration {
        seller_commission: number;
    }

    import { Input, Button, Errors, Error } from "../../Components/Form/index.svelte";
    import StatusComponent, { Status } from "./Status.svelte";
    import { Inertia } from "@inertiajs/inertia";
    export let
        config: Configuration,
        statuses: Status[],
        errors: Errors<Data>;

    const data: Data = {
        seller_commission: config.seller_commission,
        statuses: statuses,
    }

    function handleSubmit(): void
    {
        Inertia.patch('/configurations', data as any, {
            preserveScroll:  true,
            onSuccess: page => data.statuses = page.props.statuses as any,
        });
    }

    function addStatus(): void
    {
        data.statuses.push({
            name: '',
            color: '#000000',
            active: true,
        });
        data.statuses = data.statuses;
    }
</script>

<svelte:head>
    <title>Configurações</title>
</svelte:head>

<main>
    <form id="form-config" on:submit|preventDefault={handleSubmit}>
        <fieldset class="container">
            <legend>Geral</legend>
            <Input type="number" min=0 max=100 label="Comissão do vendedor" bind:value={data.seller_commission} error={errors.seller_commission} />
        </fieldset>
        <fieldset class="container">
            <legend>Status</legend>
            <Button type="button" on:click={addStatus}>
                Adicionar status
            </Button>
            <Error error={errors.statuses} />
            {#each data.statuses as _, index}
                <StatusComponent bind:statuses={data.statuses} {index} {errors}  />
            {/each}
        </fieldset>
    </form>
</main>

<aside>
    <Button type="submit" form="form-config">
        Salvar
    </Button>
</aside>