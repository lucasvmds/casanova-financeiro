<script lang="ts">
    interface User {
        id: number;
        name: string;
        email: string;
        group_name: string;
        active: boolean;
    }

    import { Button } from "../../Components/Form/index.svelte";
    import Paginate, { PaginateData } from "../../Components/Paginate.svelte";
    import { Inertia } from "@inertiajs/inertia";
    import { Link } from "@inertiajs/inertia-svelte";
    export let users: PaginateData<User>;

    function changeUserStatus(id: number): void
    {
        Inertia.delete(`/users/${id}`, { preserveScroll: true })
    }
</script>

<svelte:head>
    <title>Usuários</title>
</svelte:head>
<main>
    <div class="container">
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>E-Mail</th>
                    <th>Grupo</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                {#each users.data as user}
                    <tr>
                        <td>{user.name}</td>
                        <td>{user.email}</td>
                        <td>{user.group_name}</td>
                        <td>
                            {#if user.active}
                                <Button type="button" on:click={() => changeUserStatus(user.id)}>
                                    Ativar
                                </Button>
                            {:else}
                                <Link href="/users/{user.id}/edit">
                                    Editar
                                </Link>
                                <Button type="button" on:click={() => changeUserStatus(user.id)}>
                                    Desativar
                                </Button>
                            {/if}
                        </td>
                    </tr>
                {:else}
                    <tr>
                        <td colspan="5">Não foram encontrados registros</td>
                    </tr>
                {/each}
            </tbody>
        </table>
    </div>
    <br />
    <Paginate pages={users} step=5 max=30 />
</main>

<aside>
    <Link href="/users/create">
        Adicionar usuário
    </Link>
</aside>