<script lang="ts">
    import { Item } from "./MostActives.svelte";
    export let
        name: string,
        items: Item[];
</script>

<dt>{name}</dt>
<dd>
    <ul>
        {#each items as item, index}
            <li>
                <b>{++index}º</b> {item.name}:
                {item.number}
                <!-- {++index}º {item.name}
                <b>{item.number}</b> -->
            </li>
        {:else}
            <li>Nenhum registro encontrado</li>
        {/each}
    </ul>
</dd>