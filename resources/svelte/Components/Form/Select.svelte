<script lang="ts">
    import Error from "./Error.svelte";
    export let
        label: string,
        value: string | number| null,
        error: string | undefined,
        blank: boolean = false,
        disabled: boolean = false;
</script>

<label class="input-component" class:disabled>
    <span>{label}</span>
    <select bind:value {...$$restProps} on:change autocomplete="on" {disabled}>
        {#if blank}
            <option value="">Selecione</option>
        {/if}
        <slot />
    </select>
    
    <Error {error} />
</label>
    