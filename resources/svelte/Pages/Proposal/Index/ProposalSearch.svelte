<script lang="ts">
    import ModalButtons from "../../../Base/Modal.svelte";
    import { Input } from "../../../Components/Form/index.svelte";
    import { Inertia } from "@inertiajs/inertia";

    let search: string;

    function searchProposal(): void
    {
        const query = Object.fromEntries(
            new URLSearchParams(location.search)
        );
        delete query.page;
        delete query.search;
        if (search) query.search = search;

        Inertia.get(`/proposals/`, query, {
            preserveScroll: true,
        });
    }

    function resetSearch(): void
    {
        search = null;
        searchProposal();
    }
</script>

<form id="form-search-customer" on:submit|preventDefault={searchProposal}>
    <legend>Pesquisar propostas</legend>
    <Input type="search" label="" bind:value={search} error="" placeholder="Pesquise pelo nome do cliente, CPF (somente números) ou código da proposta" size=60 />
</form>

<ModalButtons>
    <button type="submit" form="form-search-customer">
        Pesquisar
    </button>
    <button type="button" on:click={resetSearch}>
        Limpar
    </button>
</ModalButtons>