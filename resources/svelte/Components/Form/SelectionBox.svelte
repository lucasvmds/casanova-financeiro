<script lang="ts">
    import Error from "./Error.svelte";
    export let
        type: string,
        label: string,
        value: string | number = '',
        checked: boolean = false,
        group: (string | number)[] = [],
        error: string | undefined,
        disabled: boolean = false;

    /**
     * Simula a diretiva `bind:group` do checkbox
     */
    function bindGroup(event: Event): void
    {
        const target = event.target as HTMLInputElement;
        if (target.checked) {
            group.push(target.value);
            group = group;
        } else {
            group = group.filter(value => value != target.value);
        }
    }
</script>

<!-- svelte-ignore a11y-label-has-associated-control -->
<label class="selection-box-component {type}" class:disabled>
    {#if type === 'checkgroup'}
        <input type="checkbox" {...$$restProps} {value} autocomplete='off' {disabled} checked={Boolean(group.find(item => item == value))} on:change={bindGroup} />
    {:else if type === 'checkbox'}
        <input type="checkbox" {...$$restProps} bind:checked={checked} autocomplete='off' {disabled} on:change />
    {:else if type === 'radio'}
        <input type="radio" {...$$restProps} bind:group={checked} {value} autocomplete='off' {disabled} on:change />
    {/if}

    <span>
        {label}
    </span>
</label>

<Error {error} />