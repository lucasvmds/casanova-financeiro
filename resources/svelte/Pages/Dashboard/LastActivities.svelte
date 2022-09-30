<script lang="ts">
    interface Proposal {
        id: number;
        customer_name: string;
        product_name: string;
        current_status: {
            name: string;
            color: string;
        };
        updated_at: string;
    }

    import { makeDate } from "../../../js/support";
    import { onMount, onDestroy } from "svelte";

    let proposals: Proposal[] = [];

    async function loadRegisters(): Promise<Proposal[]>
    {
        return fetch('/dashboard/last-activities')
            .then<Proposal[]>(response => response.json())
            .then(json => proposals = json);

    }

    onMount( () => {
        loadRegisters();
        document.addEventListener('dashboard:update', loadRegisters)
    });
    onDestroy( () => {
        document.removeEventListener('dashboard:update', loadRegisters)
    });
</script>

<div class="container">
    <h2>Últimas atividades</h2>
    <table>
        <tbody>
            {#each proposals as proposal}
                <tr>
                    <td>{proposal.id}</td>
                    <td>{proposal.customer_name}</td>
                    <td>{proposal.product_name}</td>
                    <td>{makeDate(proposal.updated_at).format('d/m/Y H:i')}</td>
                    <td>
                        <span style="color: #FFF; background-color: {proposal.current_status.color};">
                            {proposal.current_status.name}
                        </span>
                    </td>
                </tr>
            {:else}
                <tr>
                    <td colspan="5">Carregando propostas...</td>
                </tr>
            {/each}
        </tbody>
    </table>
</div>