<script lang="ts">
    import { onMount, onDestroy } from "svelte";
    import LastActivities from "./LastActivities.svelte";
    import MostActives from "./MostActives.svelte";
    import Count from "./Count.svelte";

    let intervalId: number;
    onMount(
        () => intervalId = setInterval(() => document.dispatchEvent(new CustomEvent('dashboard:update')), 10000) as any
    );
    onDestroy(
        () => clearInterval(intervalId)
    );
</script>

<svelte:head>
    <title>Painel</title>
</svelte:head>

<main>
    <LastActivities />
    <MostActives />
    <Count />
</main>