<script lang="ts" context="module">
    interface Status {
        id: number;
        name: string;
        color: string;
    }

    export interface ProposalStatus extends Status {
        pivot: {
            created_at: string;
            note?: string;
        }
    }
</script>

<script lang="ts">
    interface Data {
        status_id: number;
        partner_id?: number;
        required_amount: number;
        additional_info?: string;
        status_note?: string;
        contract_identifier?: string;
    }

    interface Partner {
        id: number;
        name: string;
    }

    interface Proposal extends Data {
        id: number;
        customer_id: number;
        product_name: string;
    }

    import { Button, Errors, Input, Select, TextArea } from "../../../Components/Form/index.svelte";
    import { Link } from "@inertiajs/inertia-svelte";
    import CustomerInfo from "../Common/CustomerInfo.svelte";
    import ProposalStatuses from "./ProposalStatuses.svelte";
    import { Inertia } from "@inertiajs/inertia";
    export let
        errors: Errors<Data>,
        partners: Partner[],
        proposal: Proposal,
        statuses: Status[],
        proposal_statuses: ProposalStatus[];

    const data: Data = {
        status_id: proposal.status_id,
        partner_id: proposal.partner_id || '' as null,
        required_amount: proposal.required_amount,
        additional_info: proposal.additional_info,
        status_note: proposal.status_note,
        contract_identifier: proposal.contract_identifier,
    }

    function handleSubmit(): void
    {
        Inertia.patch(`/proposals/${proposal.id}`, data as any, { preserveScroll: true });
    }
</script>

<svelte:head>
    <title>Editar proposta</title>
</svelte:head>

<main>
    <form id="form-update-proposal" on:submit|preventDefault={handleSubmit}>
        <div class="container">
            <fieldset>
                <legend>Cliente</legend>
                <CustomerInfo id={proposal.customer_id} />
            </fieldset>
            <fieldset>
                <legend>Produto</legend>
                <Input type="text" label="Produto" value={proposal.product_name} error='' readonly />
                <Select label="Parceiro" bind:value={data.partner_id} error={errors.partner_id} blank>
                    {#each partners as partner}
                        <option value={partner.id}>{partner.name}</option>
                    {/each}
                </Select>
                <br />
                <Input type="number" label="Valor requerido (R$)" bind:value={data.required_amount} error={errors.required_amount} min=0 required step="0.01" />
                <Input type="text" label="Nº Contrato" bind:value={data.contract_identifier} error={errors.contract_identifier} />
            </fieldset>
            <fieldset>
                <legend>Informações adicionais</legend>
                <TextArea label="Adicione informações que achar relevante" bind:value={data.additional_info} error={errors.additional_info} cols=60 rows=10 />
            </fieldset>
        </div>
        <div class="container">
            <fieldset>
                <legend>Status</legend>
                <Select label="" bind:value={data.status_id} error={errors.status_id} style="color: #FFF; background-color: {statuses.find(item => item.id === data.status_id).color};">
                    {#each statuses as status}
                        <option value={status.id}>{status.name}</option>
                    {/each}
                </Select>
            </fieldset>
            <fieldset>
                <legend>Histórico</legend>
                <ProposalStatuses {proposal_statuses} />
            </fieldset>
            <fieldset>
                <legend>Observação</legend>
                <TextArea label="Adicione informações que achar relevante" bind:value={data.status_note} error={errors.status_note} cols=60 rows=10 />
            </fieldset>
        </div>
    </form>
</main>

<aside>
    <Button type="submit" form="form-update-proposal">
        Salvar
    </Button>
    <Link href="/proposals">
        Voltar
    </Link>
</aside>