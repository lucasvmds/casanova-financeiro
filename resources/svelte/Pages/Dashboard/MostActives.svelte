<script lang="ts" context="module">
    export interface Item {
        name: string;
        number: number;
    }
</script>

<script lang="ts">
    interface MostActives {
        partners: Item[];
        products: Item[];
        sellers: Item[];
    }

    import ItemData from "./MostActivesItem.svelte";
    import { onMount, onDestroy } from "svelte";

    let most_actives: MostActives = undefined;

    async function loadRegisters(): Promise<MostActives>
    {
        return fetch('/dashboard/most-actives')
            .then<MostActives>(response => response.json())
            .then(json => most_actives = json);
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
    {#if most_actives}
        <dl>
            <ItemData name="Parceiros mais utilizados" items={most_actives.partners} />
            <ItemData name="Produtos mais requisitados" items={most_actives.products} />
            <ItemData name="Melhores vendedores" items={most_actives.sellers} />
        </dl>
    {:else}
        <h2>Mais utilizados</h2>
        Carregando registros...
    {/if}
</div>