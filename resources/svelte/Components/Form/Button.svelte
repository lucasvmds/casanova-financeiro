<script lang="ts">
    export let type: 'button' | 'submit';
</script>

<button {type} {...$$restProps} class="button-component" on:click>
    <slot>Button</slot>
</button>