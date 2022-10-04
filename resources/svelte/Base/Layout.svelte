<script lang="ts">
    import Header from "./Header.svelte";
    import Modal from "./ModalBase.svelte";
    import FlashMessages from "./FlashMessages.svelte";
</script>

<Header />
<FlashMessages />
<slot />
<Modal />