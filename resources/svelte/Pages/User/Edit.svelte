<script lang="ts">
    interface Errors {
        name?: string;
        email?: string;
        group?: string;
        password?: string;
        password_confirmation?: string;
    }

    interface User {
        id: number;
        name: string;
        email: string;
        group: string;
    }

    interface Data {
        name: string;
        email: string;
        group: string;
        password?: string;
        password_confirmation?: string;
    }

    import { Button, Input, Select } from "../../Components/Form/index.svelte";
    import { Inertia } from "@inertiajs/inertia";
    import { Link } from "@inertiajs/inertia-svelte";
    export let errors: Errors, user: User;

    const data: Data = {
        name: user.name,
        email: user.email,
        group: user.group,
        password: '',
        password_confirmation: '',
    };

    function updateUser(): void
    {
        Inertia.patch(`/users/${user.id}`, {...data});
    }
</script>

<svelte:head>
    <title>Editar Usuário</title>
</svelte:head>

<main>
    <form on:submit|preventDefault={updateUser} id="form-store-user">
        <div class="container">
            <h2>Dados do usuário</h2>
            <Input type="text" label="Nome" required bind:value={data.name} error={errors.name} size=30 />
            <Input type="email" label="E-Mail" required bind:value={data.email} error={errors.email} size=50 />
            <br />
            <Select label="Grupo" blank bind:value={data.group} error={errors.group} required>
                <option value="seller">Vendedor</option>
                <option value="manager">Gerente</option>
                <option value="admin">Administrador</option>
            </Select>
            <br />
            <Input type="password" label="Senha" bind:value={data.password} error={errors.password} size=30 />
            <Input type="password" label="Confirmar senha" bind:value={data.password_confirmation} error={errors.password_confirmation} size=30 />
        </div>
    </form>
</main>

<aisde>
    <Button type="submit" form="form-store-user">
        Salvar
    </Button>
    
    <Link href="/users">
        Voltar
    </Link>
</aisde>
