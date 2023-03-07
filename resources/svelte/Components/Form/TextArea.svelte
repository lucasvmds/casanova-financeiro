<script lang="ts">
    import Error from "./Error.svelte";
    export let
        label: string,
        value: string | number | undefined,
        error: string | undefined,
        disabled: boolean = false;
</script>

<label class="input-component" class:disabled>
    <span>{label}</span>
    <textarea bind:value autocomplete="off" {...$$restProps} {disabled} on:input></textarea>
    <Error {error} />
</label>