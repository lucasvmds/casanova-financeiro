<script lang="ts" context="module">
    import { closeModal, openModal } from "./ModalBase.svelte";
    export { closeModal, openModal };
</script>

<div id="buttons">
    <slot />
    <button type="button" on:click={closeModal}>
        Fechar
    </button>
</div>