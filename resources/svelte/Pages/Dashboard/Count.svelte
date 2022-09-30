<script lang="ts">
    interface Numbers {
        proposals: {
            open: number;
            closed: number;
            approved: number;
        }
        approved_amount: number;
        business_commission: number;
    }

    import { onMount, onDestroy } from "svelte";

    let numbers: Numbers = undefined;

    async function loadRegisters(): Promise<Numbers>
    {
        return fetch('/dashboard/numbers')
            .then<Numbers>(response => response.json())
            .then(json => numbers = json);

    }

    onMount( () => {
        loadRegisters();
        document.addEventListener('dashboard:update', loadRegisters)
    });
    onDestroy( () => {
        document.removeEventListener('dashboard:update', loadRegisters)
    });
</script>

<dl class="container">
    <dt>Propostas aprovadas</dt>
    <dd>{numbers?.proposals.approved ?? '...'}</dd>
    <dt>Propostas fechadas</dt>
    <dd>{numbers?.proposals.closed ?? '...'}</dd>
    <dt>Propostas em aberto</dt>
    <dd>{numbers?.proposals.open ?? '...'}</dd>
    <dt>Valores aprovados</dt>
    <dd>R${numbers?.approved_amount ?? '...'}</dd>
    <dt>Comissões totais</dt>
    <dd>R${numbers?.business_commission ?? '...'}</dd>
</dl>