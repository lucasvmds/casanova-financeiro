<script lang="ts" context="module">
    export type Errors<T> = {
        [K in keyof T]?: string;
    }
</script>

<script lang="ts">
    export let error: string | undefined;
</script>

{#if error}
    <br />
    <small>
        <i>{error}</i>
    </small>
{/if}