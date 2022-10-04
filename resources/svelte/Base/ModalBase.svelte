<script lang="ts" context="module">
    import { modalContent, ModalProps, SvelteComponent } from "../../js/stores/modal";

    interface OpenModalArguments<T> {
        component: T | string;
        props?: ModalProps;
        closeButton?: boolean;
    }

    export function openModal<T>({component, props = {}, closeButton = false}: OpenModalArguments<T>): void
    {
        modalContent.set({
            component,
            props,
            closeButton
        });
    }

    export function closeModal(): void
    {
        modalContent.set({
            component: null,
            props: null,
            closeButton: false,
        });
    }
</script>

<script lang="ts">
    import Buttons from "./Modal.svelte";

    $: component = $modalContent.component;
    $: props = $modalContent.props;
    $: closeButton = $modalContent.closeButton;
</script>

<div id="dialog" role="dialog" class:open={component !== null}>
    <div id="dialog-body">
        {#if typeof component === 'string'}
            {@html component}
        {:else}
            <svelte:component this={component} {props} />
        {/if}

        {#if closeButton}
            <Buttons />
        {/if}
    </div>
</div>