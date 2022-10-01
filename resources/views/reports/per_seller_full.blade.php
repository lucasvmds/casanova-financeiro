@extends('reports.base')
@section($title)

@section('content')
    @foreach ($commissions as $commission)
        <table>
            <caption>{{$commission['name']}}</caption>
            <thead>
                <tr>
                    <th>Proposta</th>
                    <th>Valor requerido</th>
                    <th>% da empresa</th>
                    <th>Valor da empresa</th>
                    <th>% do vendedor</th>
                    <th>Valor do vendedor</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($commission['proposals'] as $proposal)
                    <tr>
                        <td>{{$proposal['id']}}</td>
                        <td>{{$proposal['required_amount']}}</td>
                        <td>{{$proposal['business_percentage']}}</td>
                        <td>{{$proposal['business_amount']}}</td>
                        <td>{{$proposal['percentage']}}</td>
                        <td>{{$proposal['amount']}}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="2"></td>
                    <td colspan="2">
                        <b>Total da empresa:</b> {{$commission['business_total']}}
                    </td>
                    <td colspan="2">
                        <b>Total do vendedor:</b> {{$commission['total']}}
                    </td>
                </tr>
            </tbody>
        </table>
    @endforeach
@endsection