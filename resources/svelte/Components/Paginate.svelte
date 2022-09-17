<script lang="ts" context="module">
    interface Paginate {
        current_page: number;
        per_page: number;
        last_page: number;
        data: Array<Object>;
    }

    export interface PaginateData<T> extends Paginate {
        data: Array<T>;
    }
</script>

<script lang="ts">
    import { Select } from "./Form/index.svelte";
    import { Inertia } from "@inertiajs/inertia";
    export let pages: Paginate, step: string, max: string;

    const maxNumber: number = parseInt(max);
    const stepNumber: number = parseInt(step);

    $: currentPage = pages.current_page;
    $: currentItems = pages.per_page;
    
    /**
     * Faz a consulta dos novos dados de acordo com os valores dos seletores
     */
    function changePage(): void
    {
        const data = Object.fromEntries<string | number | null>(
            new URLSearchParams(location.search)
        );
        delete data.page;
        delete data.items;
        currentPage > 1 ? data.page = currentPage : null;
        currentItems > stepNumber ? data.items = currentItems : null;
        console.log(data);
        Inertia.get(location.pathname, data, { preserveScroll: true });
    }
</script>

<div class="container">
    <Select label="Página" bind:value={currentPage} error="" on:change={changePage}>
        {#each Array(pages.last_page) as _, index}
            {++index}
            <option value={index}>{index}</option>
        {/each}
    </Select>
    <Select label="Itens por página" bind:value={currentItems} error="" on:change={changePage}>
        {#each Array(maxNumber / stepNumber) as _, index}
            {index = (index + 1) * stepNumber}
            <option value={index}>{index}</option>
        {/each}
    </Select>
</div>