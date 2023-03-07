<script lang="ts">
    interface Partner {
        id: number;
        name: string;
        linked: number;
        active: boolean;
    }

    import { Button } from "../../Components/Form/index.svelte";
    import { Inertia } from "@inertiajs/inertia";
    import { page } from "@inertiajs/inertia-svelte";

    let partners: Partner[];
    $: partners = $page.props.partners || [];

    function changePartnerStatus(id: number): void
    {
        Inertia.delete(`/partners/${id}`, { preserveScroll: true });
    }

    function openEditionPage(id: number): void
    {
        Inertia.get(`/partners/${id}/edit`, {}, {
            onFinish: () => document.dispatchEvent(new CustomEvent('custom:refresh')),
        });
    }
</script>

<div class="container">
    <table>
        <thead>
            <tr>
                <th>Nome</th>
                <th>Produtos</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            {#each partners as item}
                <tr>
                    <td>{item.name}</td>
                    <td>{item.linked}</td>
                    <td>
                        {#if !item.active}
                                <Button type="button" on:click={() => changePartnerStatus(item.id)}>
                                    Ativar
                                </Button>
                            {:else}
                                <Button type="button" on:click={() => openEditionPage(item.id)}>
                                    Editar
                                </Button>
                                <Button type="button" on:click={() => changePartnerStatus(item.id)}>
                                    Desativar
                                </Button>
                            {/if}
                    </td>
                </tr>
            {/each}
        </tbody>
    </table>
</div>