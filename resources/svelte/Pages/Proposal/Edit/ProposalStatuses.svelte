<script lang="ts">
    import { makeDate } from "../../../../js/support";
    import { ProposalStatus } from "./Main.svelte";
    export let
        proposal_statuses: ProposalStatus[];
</script>

<table>
    <tbody>
        {#each proposal_statuses as status}
            <tr>
                <td>{status.pivot.note || '---------'}</td>
                <td>{makeDate(status.pivot.created_at).format('d/m/Y H:i')}</td>
                <td style="color: #FFF; background-color: {status.color};">
                    {status.name}
                </td>
            </tr>
        {/each}
    </tbody>
</table>