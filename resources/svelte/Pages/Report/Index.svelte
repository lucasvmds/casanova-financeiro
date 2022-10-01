<script lang="ts">
    interface Data {
        report_type: string;
        initial_date: string;
        final_date: string;
    }

    import { SelectionBox, Button, Input, Errors, Error } from "../../Components/Form/index.svelte";
    import { Inertia } from "@inertiajs/inertia";
    export let errors: Errors<Data>, url: string | null;

    const data: Data = {
        report_type: null,
        initial_date: null,
        final_date: null,
    }

    $: {
        if (url) window.open(url, '', 'popup,noopener,noreferrer');
    }

    function handleSubmit(): void
    {
        Inertia.post('/reports/url', data as any, {
            preserveScroll: true,
        });
    }
</script>

<svelte:head>
    <title>Relatórios</title>
</svelte:head>

<main>
    <form id="form-report" class="container" on:submit|preventDefault={handleSubmit}>
        <fieldset>
            <legend>Tipo</legend>
            <SelectionBox label="Comissão por vendedor (simples)" required value="per_seller_simple" name="report-type" type="radio" bind:selected={data.report_type} error="" />
            <SelectionBox label="Comissão por vendedor (completa)" required value="per_seller_full" name="report-type" type="radio" bind:selected={data.report_type} error="" />
            <Error error={errors.report_type} />
        </fieldset>
        <fieldset>    
            <legend>Período</legend>
            <Input type="date" label="Data inicial" required bind:value={data.initial_date} error={errors.initial_date} />
            <Input type="date" label="Data final" required bind:value={data.final_date} error={errors.final_date} />
        </fieldset>
    </form>
</main>

<aside>
    <Button type="submit" form="form-report">
        Gerar relatório
    </Button>
</aside>