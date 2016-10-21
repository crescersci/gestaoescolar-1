@extends('layouts.app')

@section('content')
<div class="container">

    <h1>Edit nota {{ $nota->id }}</h1>

    {!! Form::model($nota, [
        'method' => 'PATCH',
        'url' => ['/admin/notas', $nota->id],
        'class' => 'form-horizontal',
        'files' => true
    ]) !!}

                    <div class="form-group {{ $errors->has('nota') ? 'has-error' : ''}}">
                {!! Form::label('nota', 'Nota', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::text('nota', null, ['class' => 'form-control']) !!}
                    {!! $errors->first('nota', '<p class="help-block">:message</p>') !!}
                </div>
            </div>


        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-3">
                {!! Form::submit('Update', ['class' => 'btn btn-primary form-control']) !!}
            </div>
        </div>
    {!! Form::close() !!}

    @if ($errors->any())
        <ul class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

</div>
@endsection