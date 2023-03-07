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

    import { Input, SelectionBox, Error } from "../../Components/Form/index.svelte";
    import { Inertia } from "@inertiajs/inertia";
    import { loop_guard } from "svelte/internal";
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
    <div class="container">
        <h1>
            <img src="/logo.png" alt="logo da casa nova créditos" />
        </h1>
        <form on:submit|preventDefault={handleSubmit} id="form-login">
            <Input type="email" label="Usuário" bind:value={data.email} error={errors.email} required size=20 />
            <br />
            <Input type="password" label="Senha" bind:value={data.password} error={errors.password} required size=20 />
            <br />
            <SelectionBox type="checkbox" label="Manter conectado" bind:checked={data.remember} error={errors.remember} />
            <br />
            <Error error={errors.failed} />
        </form>
        <button type="submit" form="form-login">Acessar</button>
    </div>
</main>