<script lang="ts">
    interface Proposal {
        id: number;
        current_status: { name: string, color: string };
        customer_name: string;
        product_name: string;
        seller_name: string;
        created_at: string;
        updated_at: string;
    }

    import { Button } from "../../../Components/Form/index.svelte";
    import { Link } from "@inertiajs/inertia-svelte";
    import Paginate, { PaginateData } from "../../../Components/Paginate.svelte";
    import { makeDate } from "../../../../js/support";
    import { openModal } from "../../../Base/Modal.svelte";
    import ProposalSearch from "./ProposalSearch.svelte";
    export let
        proposals: PaginateData<Proposal>;

    function openSearchModal(): void
    {
        openModal({
            component: ProposalSearch,
        });
    }
</script>

<svelte:head>
    <title>Propostas</title>
</svelte:head>

<main>
    <div class="container">
        <table>
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Cliente</th>
                    <th>Produto</th>
                    <th>Status</th>
                    <th>Vendedor</th>
                    <th>Criada em</th>
                    <th>Última atualização</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                {#each proposals.data as proposal}
                    <tr>
                        <td>{proposal.id}</td>
                        <td>{proposal.customer_name}</td>
                        <td>{proposal.product_name}</td>
                        <td style="color: #FFF; background-color: {proposal.current_status.color};">{proposal.current_status.name}</td>
                        <td>{proposal.seller_name}</td>
                        <td>
                            {makeDate(proposal.created_at).format('d/m/Y H:i')}
                        </td>
                        <td>
                            {makeDate(proposal.updated_at).format('d/m/Y H:i')}
                        </td>
                        <td>
                            <Link href="/proposals/{proposal.id}/edit">
                                Editar
                            </Link>
                        </td>
                    </tr>
                {:else}
                    <td colspan="8">Nenhuma proposta encontrada</td>
                {/each}
            </tbody>
        </table>
    </div>
    <br />
    <Paginate pages={proposals} max=100 step=20 />
</main>

<aside>
    <Link href="/proposals/create">
        Cadastrar proposta
    </Link>
    <Button type="button" on:click={openSearchModal}>
        Pesquisar
    </Button>
</aside>