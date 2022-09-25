<script lang="ts">
    interface Product {
        id: number;
        name: string;
        commission: number;
        linked: number;
        active: boolean;
    }

    import { Button } from "../../Components/Form/index.svelte";
    import { Inertia } from "@inertiajs/inertia";
    import { page } from "@inertiajs/inertia-svelte";

    let products: Product[];
    $: products = $page.props.products || [];

    function changeProductStatus(id: number): void
    {
        Inertia.delete(`/products/${id}`, { preserveScroll: true });
    }

    function openEditionPage(id: number): void
    {
        Inertia.get(`/products/${id}/edit`, {}, {
            onFinish: () => document.dispatchEvent(new CustomEvent('custom:refresh')),
        });
    }
</script>

<div class="container">
    <table>
        <thead>
            <tr>
                <th>Nome</th>
                <th>Comissão</th>
                <th>Parceiros</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            {#each products as item}
                <tr>
                    <td>{item.name}</td>
                    <td>{item.commission}</td>
                    <td>{item.linked}</td>
                    <td>
                        {#if !item.active}
                                <Button type="button" on:click={() => changeProductStatus(item.id)}>
                                    Ativar
                                </Button>
                            {:else}
                                <Button type="button" on:click={() => openEditionPage(item.id)}>
                                    Editar
                                </Button>
                                <Button type="button" on:click={() => changeProductStatus(item.id)}>
                                    Desativar
                                </Button>
                            {/if}
                    </td>
                </tr>
            {/each}
        </tbody>
    </table>
</div>