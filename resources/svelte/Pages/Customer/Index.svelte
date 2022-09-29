<script lang="ts">
    interface Customer {
        id: number;
        name: string;
        cpf: number;
        phone: number;
        location: string;
    }

    import Paginate, { PaginateData } from "../../Components/Paginate.svelte";
    import { Link } from "@inertiajs/inertia-svelte";
    import Button from "../../Components/Form/Button.svelte";
    import { openModal } from "../../Base/Modal.svelte";
    import CustomerSearch from "./CustomerSearch.svelte";
    export let customers: PaginateData<Customer>;

    function openSearchCustomersModal(): void
    {
        openModal({
            component: CustomerSearch
        });
    }
</script>

<svelte:head>
    <title>Clientes</title>
</svelte:head>
<main>
    <div class="container">
        <table>
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Nome</th>
                    <th>CPF</th>
                    <th>Telefone</th>
                    <th>Cidade</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                {#each customers.data as customer}
                    <tr>
                        <td>{customer.id}</td>
                        <td>{customer.name}</td>
                        <td>{customer.cpf}</td>
                        <td>{customer.phone}</td>
                        <td>{customer.location}</td>
                        <td>
                            <Link href="/customers/{customer.id}/edit">
                                Editar
                            </Link>
                        </td>
                    </tr>
                {:else}
                    <tr>
                        <td colspan="5">Não foram encontrados registros</td>
                    </tr>
                {/each}
            </tbody>
        </table>
    </div>
    <br />
    <Paginate pages={customers} step=20 max=100 />
</main>

<aside>
    <Link href="/customers/create">
        Adicionar cliente
    </Link>
    <Button type="button" on:click={openSearchCustomersModal}>
        Pesquisar
    </Button>
</aside>