<script lang="ts" context="module">
    export interface ContactData {
        id?: number;
        name: string;
        phone: string;
        email?: string;
    }
</script>

<script lang="ts">
    import { Data } from "./CreateEdit.svelte";
    import { Input, Button, Errors } from "../../Components/Form/index.svelte";
    export let
        contacts: ContactData[],
        index: number,
        errors: Errors<Data>;

    function removeContact(): void
    {
        contacts = contacts.filter(
            (value, dataIndex) => dataIndex !== index
        );
    }
</script>

<div class="contact-component">
    <Input type="text" label="Nome" bind:value={contacts[index].name} error={errors[`contacts.${index}.name`]} size=40 required />
    <Input type="tel" label="Telefone" bind:value={contacts[index].phone} error={errors[`contacts.${index}.phone`]} required />
    <br />
    <Input type="email" label="E-Mail" bind:value={contacts[index].email} error={errors[`contacts.${index}.email`]} size=60 />
    <br />
    <Button type="button" on:click={removeContact}>
        Remover contato
    </Button>
</div>
