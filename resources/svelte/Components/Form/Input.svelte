<script lang="ts">
    import Error from "./Error.svelte";
    export let
        type: string,
        label: string,
        value: string | number | undefined,
        error: string | undefined,
        disabled: boolean = false;
</script>

<!-- svelte-ignore a11y-label-has-associated-control -->
<label class="input-component" class:disabled>
    <span>{label}</span>

    {#if type === 'password'}
        <input type="password" bind:value autocomplete="off" {...$$restProps} {disabled} on:input />
    {:else if type === 'number'}
        <input type="number" bind:value autocomplete="off" {...$$restProps} {disabled} on:input />
    {:else if type === 'email'}
        <input type="email" bind:value autocomplete="off" {...$$restProps} {disabled} on:input />
    {:else if type === 'text'}
        <input type="text" bind:value autocomplete="off" {...$$restProps} {disabled} on:input />
    {:else if type === 'tel'}
        <input type="tel" bind:value autocomplete="off" {...$$restProps} {disabled} on:input />
    {:else if type === 'date'}
        <input type="date" bind:value autocomplete="off" {...$$restProps} {disabled} on:input />
    {:else if type === 'time'}
        <input type="time" bind:value autocomplete="off" {...$$restProps} {disabled} on:input />
    {:else if type === 'datetime-local'}
        <input type="datetime-local" bind:value autocomplete="off" {...$$restProps} {disabled} on:input />
    {:else if type === 'search'}
        <input type="search" bind:value autocomplete="off" {...$$restProps} {disabled} on:input />
    {/if}
    
    <Error {error} />
</label>