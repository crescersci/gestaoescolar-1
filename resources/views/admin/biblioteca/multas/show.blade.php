@extends('layouts.app')

@section('content')
<div class="container">

    <h1>multa {{ $multa->id }}
        <a href="{{ url('admin/biblioteca/multas/' . $multa->id . '/edit') }}" class="btn btn-primary btn-xs" title="Edit multa"><span class="glyphicon glyphicon-pencil" aria-hidden="true"/></a>
        {!! Form::open([
            'method'=>'DELETE',
            'url' => ['admin/biblioteca/multas', $multa->id],
            'style' => 'display:inline'
        ]) !!}
            {!! Form::button('<span class="glyphicon glyphicon-trash" aria-hidden="true"/>', array(
                    'type' => 'submit',
                    'class' => 'btn btn-danger btn-xs',
                    'title' => 'Delete multa',
                    'onclick'=>'return confirm("Confirm delete?")'
            ))!!}
        {!! Form::close() !!}
    </h1>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tbody>
                <tr>
                    <th>ID</th><td>{{ $multa->id }}</td>
                </tr>
                <tr><th> Valor </th><td> R$ {{ number_format($multa->valor, 2, ",", ".") }} </td></tr>
                <tr><th> Data Pagamento </th><td> {{ date('d/m/Y', strtotime($multa->data_pagamento)) }} </td></tr>
                <tr><th> Tipo Multa </th><td> {{ $multa->tipomulta->nome }} </td></tr>
            </tbody>
        </table>
    </div>

</div>
@endsection