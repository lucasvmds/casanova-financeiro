@extends('reports.base')
@section($title)

@section('content')
    <table>
        <thead>
            <tr>
                <th>Código do vendedor</th>
                <th>Nome do Vendedor</th>
                <th>Valor</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($commissions as $commission)
                <tr>
                    <td>{{$commission->id}}</td>
                    <td>{{$commission->name}}</td>
                    <td>{{$commission->amount}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection