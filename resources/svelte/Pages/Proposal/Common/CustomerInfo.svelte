<script lang="ts">
    interface CustomerInfo {
        name: string;
        birth_date: string;
        cpf: number;
        rg: number;
        street: string;
        number: string;
        district: string;
        complement?: string;
        cep: number;
        location: string;
    }

    import { Input } from "../../../Components/Form/index.svelte";
    export let id: number;

    let customer: CustomerInfo = {} as CustomerInfo;

    $: {
        fetch(`/customers/${id}`)
            .then<CustomerInfo>(response => response.json())
            .then(json => customer = json);
    }
</script>

<Input type="text" label="Nome completo" value={customer.name} readonly error='' size=60 />
<br />
<Input type="date" label="Data de nascimento" value={customer.birth_date} readonly error='' />
<Input type="text" label="CPF" value={customer.cpf} readonly error='' size=14 />
<Input type="text" label="RG" value={customer.rg} readonly error='' size=14 />
<br />
<Input type="text" label="Rua" value={customer.street} readonly error='' size=60 />
<Input type="text" label="Número" value={customer.number} readonly error='' size=10 />
<br />
<Input type="text" label="Bairro" value={customer.district} readonly error='' size=30 />
<Input type="text" label="Complemento" value={customer.complement} readonly error='' size=30 />
<br />
<Input type="text" label="CEP" value={customer.cep} readonly error='' size=12 />
<Input type="text" label="Cidade" value={customer.location} readonly error='' size=30 />