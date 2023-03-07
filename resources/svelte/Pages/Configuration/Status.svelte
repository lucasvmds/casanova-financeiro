<script lang="ts" context="module">
    export interface Status {
        id?: number;
        name: string;
        color: string;
        main: 'open' | 'approved' | 'closed';
        active: boolean;
    }
</script>

<script lang="ts">
    import { Input, SelectionBox, Errors, Button, Error } from "../../Components/Form/index.svelte";
    import Select from "../../Components/Form/Select.svelte";
    import { Data } from "./Index.svelte";
    export let
        statuses: Status[],
        index: number,
        errors: Errors<Data>;

    const mainStatus: Record<Status['main'], string> = {
        open: 'Em Aberto',
        approved: 'Aprovado',
        closed: 'Fechado',
    }

    function removeStatus(): void
    {
        statuses = statuses.filter(
            (value, dataIndex) => dataIndex !== index
        );
    }
</script>

<div class="status-component">
    <Input type="text" label="Nome" required size=30 bind:value={statuses[index].name} error={errors[`statuses.${index}.name`]} />
    <Input type="color" label="Cor" required bind:value={statuses[index].color} error={errors[`statuses.${index}.color`]} />

    {#if statuses[index].id === undefined}
        <Select label="Status Principal" bind:value={statuses[index].main} error={errors[`statuses.${index}.main`]}>
            <option value="open">{mainStatus.open}</option>
            <option value="approved">{mainStatus.approved}</option>
            <option value="closed">{mainStatus.closed}</option>
        </Select>
    {:else if statuses[index].id > 3}
        <Input type="text" label="Status Principal" value={mainStatus[ statuses[index].main ]} error='' readonly size=9 />
    {/if}

    {#if statuses[index].id > 3 || statuses[index].id === undefined}
        <SelectionBox type="checkbox" label="Ativo" bind:checked={statuses[index].active} error={errors[`statuses.${index}.active`]} />
    {/if}

    {#if ! statuses[index].id}
        <Button type="button" on:click={removeStatus}>
            Remover
        </Button>
    {/if}

    <Error error={errors[`statuses.${index}`]} />
    <Error error={errors[`statuses.${index}.id`]} />
</div>
