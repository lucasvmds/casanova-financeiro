<script lang="ts">
    import { Link } from "@inertiajs/inertia-svelte";
    import { Button } from "../Components/Form/index.svelte";
    import { Inertia } from "@inertiajs/inertia";

    function destroySession(): void
    {
        Inertia.delete('/session');
    }
</script>

<header id="app-header">
    <nav>
        <Link href="/">Dashboard</Link>
        <Link href="/customers">Clientes</Link>
        <Link href="/proposals">Propostas</Link>
        <Link href="/partners">Parceiros</Link>
        <Link href="/products">Produtos</Link>
        <Link href="/users">Usuários</Link>
        <Link href="/reports">Relatórios</Link>
        <Link href="/configurations">Configurações</Link>
    </nav>

    <div>
        <Link href="/session/edit">
            Modificar usuário
        </Link>
        <Button type="button" on:click={destroySession}>Sair</Button>
    </div>
</header>