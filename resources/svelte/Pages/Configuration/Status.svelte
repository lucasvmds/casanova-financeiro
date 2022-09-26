<script lang="ts" context="module">
    export interface Status {
        id?: number;
        name: string;
        color: string;
        active: boolean;
    }
</script>

<script lang="ts">
    import { Input, SelectionBox, Errors, Button, Error } from "../../Components/Form/index.svelte";
    import { Data } from "./Index.svelte";
    export let
        statuses: Status[],
        index: number,
        errors: Errors<Data>;

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

    {#if statuses[index].id > 3 || statuses[index].id === undefined}
        <SelectionBox type="checkbox" label="Ativo" bind:checked={statuses[index].active} error={errors[`statuses.${index}.active`]} />
    {/if}

    {#if ! statuses[index].id}
        <Button type="button" on:click={removeStatus}>
            Remover
        </Button>
    {/if}

    <Error error={errors[`statuses.${index}.id`]} />
</div>
