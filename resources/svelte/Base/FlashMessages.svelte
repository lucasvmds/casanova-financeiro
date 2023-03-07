<script lang="ts">
    type Message = {
        id: string;
        level: string;
        content: string;
    }
    import { page } from "@inertiajs/inertia-svelte";
    import { scale } from "svelte/transition";
    import { flip } from "svelte/animate";

    let messages: Message[]
    $: messages = $page.props.flash_messages || [];

    function removeMessage(id: string): void
    {
        messages = messages.filter(item => item.id !== id);
    }
</script>

{#if messages.length > 0}
    <div id="messages-component">
        {#each messages as message (message.id)}
            <div role="alert" class="message {message.level}" transition:scale={{duration: 200}} on:click={() => removeMessage(message.id)} animate:flip={{duration: 200}}>
                {message.content}
            </div>
        {/each}
    </div>
{/if}