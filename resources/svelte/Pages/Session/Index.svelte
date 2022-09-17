<script lang="ts">
    interface Errors {
        email?: string;
        password?: string;
        remember?: string;
        failed?: string;
    }

    interface Data {
        email?: string;
        password?: string;
        remember: boolean;
    }

    import { Input, SelectionBox, Button, Error } from "../../Components/Form/index.svelte";
    import { Inertia } from "@inertiajs/inertia";
    export let errors: Errors;
    
    const data: Data = {
        email: '',
        password: '',
        remember: false,
    };

    function handleSubmit(): void
    {
        Inertia.post('/session', {...data});
    }
</script>
<svelte:head>
    <title>Login</title>
</svelte:head>

<main id="login-page">
    <h1>Login</h1>
    <form on:submit|preventDefault={handleSubmit}>
        <Input type="email" label="Usuário" bind:value={data.email} error={errors.email} required />
        <br />
        <Input type="password" label="Senha" bind:value={data.password} error={errors.password} required />
        <br />
        <SelectionBox type="checkbox" label="Manter conectado" bind:checked={data.remember} error={errors.remember} />
        <br />
        <br />
        <Button type="submit">Acessar</Button>
        <br />
        {#if errors.failed}
            <Error error={errors.failed} />
        {/if}
    </form>
</main>