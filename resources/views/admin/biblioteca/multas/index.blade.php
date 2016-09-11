@extends('layouts.app')

@section('content')
<div class="container">

    <h1>Multas <a href="{{ url('/admin/biblioteca/multas/create') }}" class="btn btn-primary btn-xs" title="Add New multa"><span class="glyphicon glyphicon-plus" aria-hidden="true"/></a></h1>
    <div class="table">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th> Valor </th>
                    <th> Data Pagamento </th>
                    <th> Tipo Multa </th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            {{-- */$x=0;/* --}}
            @foreach($multas as $item)
                {{-- */$x++;/* --}}
                <tr>
                    <td>{{ $x }}</td>
                    <td>R$ {{ number_format($item->valor, 2, ",", ".") }}</td>
                    <td>{{ date('d/m/Y', strtotime($item->data_pagamento)) }}</td>
                    <td>{{ $item->tipomulta->nome }}</td>
                    <td>
                        <a href="{{ url('/admin/biblioteca/multas/' . $item->id) }}" class="btn btn-success btn-xs" title="View multa"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"/></a>
                        <a href="{{ url('/admin/biblioteca/multas/' . $item->id . '/edit') }}" class="btn btn-primary btn-xs" title="Edit multa"><span class="glyphicon glyphicon-pencil" aria-hidden="true"/></a>
                        {!! Form::open([
                            'method'=>'DELETE',
                            'url' => ['/admin/biblioteca/multas', $item->id],
                            'style' => 'display:inline'
                        ]) !!}
                            {!! Form::button('<span class="glyphicon glyphicon-trash" aria-hidden="true" title="Delete multa" />', array(
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger btn-xs',
                                    'title' => 'Delete multa',
                                    'onclick'=>'return confirm("Confirm delete?")'
                            )) !!}
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="pagination-wrapper"> {!! $multas->render() !!} </div>
    </div>

</div>
@endsection