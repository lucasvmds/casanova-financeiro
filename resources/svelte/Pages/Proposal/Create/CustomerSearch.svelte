<script lang="ts">
    interface Customer {
        id: number;
        name: string;
        cpf: number;
        phone: number;
        location: string;
    }

    import ModalButtons, { closeModal } from "../../../Base/Modal.svelte";
    import { Input } from "../../../Components/Form/index.svelte";

    let
        search: string,
        customers: Customer[] = undefined;

    function searchCustomer(): void
    {
        fetch(`/customers-search/?search=${search || ''}`)
            .then<Customer[]>(response => response.json())
            .then(json => customers = json);
    }

    function selectCustomer(id: number): void
    {
        document.dispatchEvent(
            new CustomEvent('proposal:customerselected', {
                detail: { id },
            })
        );
        closeModal();
    }
</script>

<form id="form-search-customer" on:submit|preventDefault={searchCustomer}>
    <Input type="search" label="Pesquisar" bind:value={search} error={''} placeholder="Pesquise por nome ou CPF" size=60 />

    {#if customers}
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>CPF</th>
                    <th>Telefone</th>
                    <th>Cidade</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                {#each customers as customer}
                    <tr>
                        <td>{customer.name}</td>
                        <td>{customer.cpf}</td>
                        <td>{customer.phone}</td>
                        <td>{customer.location}</td>
                        <td>
                            <button type="button" on:click={() => selectCustomer(customer.id)}>
                                Selecionar
                            </button>
                        </td>
                    </tr>
                {:else}
                    <tr>
                        <td colspan="5">Não foram encontrados resultados</td>
                    </tr>
                {/each}
            </tbody>
        </table>
    {/if}
</form>

<ModalButtons>
    <button type="submit" form="form-search-customer">
        Pesquisar
    </button>
</ModalButtons>