<script lang="ts">
    import ModalButtons from "../../Base/Modal.svelte";
    import { Input } from "../../Components/Form/index.svelte";
    import { Inertia } from "@inertiajs/inertia";

    let search: string;

    function searchCustomer(): void
    {
        const query = Object.fromEntries(
            new URLSearchParams(location.search)
        );
        delete query.page;
        delete query.search;
        if (search) query.search = search;

        Inertia.get(`/customers/`, query, {
            preserveScroll: true,
        });
    }

    function resetSearch(): void
    {
        search = null;
        searchCustomer();
    }
</script>

<form id="form-search-customer" on:submit|preventDefault={searchCustomer}>
    <legend>
        Pesquisar clientes
    </legend>
    <Input type="search" label="" bind:value={search} error="" placeholder="Pesquise pelo nome, nome da rua ou CPF (somente números)" size=60 />
</form>

<ModalButtons>
    <button type="submit" form="form-search-customer">
        Pesquisar
    </button>
    <button type="button" on:click={resetSearch}>
        Limpar
    </button>
</ModalButtons>