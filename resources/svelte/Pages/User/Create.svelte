<script lang="ts">
    interface Data {
        name: string;
        email: string;
        group: string;
        password: string;
        password_confirmation: string;
    }

    import { Button, Input, Select, Errors } from "../../Components/Form/index.svelte";
    import { Inertia } from "@inertiajs/inertia";
    import { Link } from "@inertiajs/inertia-svelte";
    export let errors: Errors<Data>;

    const data: Data = {
        name: '',
        email: '',
        group: '',
        password: '',
        password_confirmation: '',
    };

    function addUser(): void
    {
        Inertia.post('/users', {...data});
    }
</script>

<svelte:head>
    <title>Adicionar Usuário</title>
</svelte:head>

<main>
    <form on:submit|preventDefault={addUser} id="form-store-user" class="container">
        <fieldset>
            <legend>Dados do usuário</legend>
            <Input type="text" label="Nome" required bind:value={data.name} error={errors.name} size=30 />
            <Input type="email" label="E-Mail" required bind:value={data.email} error={errors.email} size=50 />
            <br />
            <Select label="Grupo" blank bind:value={data.group} error={errors.group} required>
                <option value="seller">Vendedor</option>
                <option value="manager">Gerente</option>
                <option value="admin">Administrador</option>
            </Select>
            <br />
            <Input type="password" label="Senha" required bind:value={data.password} error={errors.password} size=30 />
            <Input type="password" label="Confirmar senha" required bind:value={data.password_confirmation} error={errors.password_confirmation} size=30 />
        </fieldset>
    </form>
</main>

<aside>
    <Button type="submit" form="form-store-user">
        Salvar
    </Button>
    
    <Link href="/users">
        Voltar
    </Link>
</aside>
