<script lang="ts">
    interface User {
        id: number;
        name: string;
        email: string;
    }

    interface Data {
        name: string;
        email: string;
        current_password: string;
        password?: string;
        password_confirmation?: string;
    }

    import { Button, Input, Errors } from "../../Components/Form/index.svelte";
    import { Inertia } from "@inertiajs/inertia";
    import { Link } from "@inertiajs/inertia-svelte";
    export let errors: Errors<Data>, user: User;

    const data: Data = {
        name: user.name,
        email: user.email,
        current_password: '',
        password: '',
        password_confirmation: '',
    };

    function handleSubmit(): void
    {
        Inertia.patch('/session', data as any);
    }
</script>

<svelte:head>
    <title>Modificar Usuário</title>
</svelte:head>

<main>
    <form on:submit|preventDefault={handleSubmit} id="form-update-session">
        <fieldset class="container">
            <legend>Dados do usuário</legend>
            <Input type="text" label="Nome" required bind:value={data.name} error={errors.name} size=30 />
            <Input type="email" label="E-Mail" required bind:value={data.email} error={errors.email} size=50 />
            <br />
            <Input type="password" label="Senha atual" required bind:value={data.current_password} error={errors.current_password} size=30 />
            <br />
            <br />
            <Input type="password" label="Senha" bind:value={data.password} error={errors.password} size=30 />
            <Input type="password" label="Confirmar senha" bind:value={data.password_confirmation} error={errors.password_confirmation} size=30 />
        </fieldset>
    </form>
</main>

<aisde>
    <Button type="submit" form="form-update-session">
        Salvar
    </Button>
    
    <Link href="/">
        Voltar
    </Link>
</aisde>
