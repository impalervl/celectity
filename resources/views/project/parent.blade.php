@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <h1>Форма расчёта для присоединения</h1>
        <div class="form-group">
            {!! Form::open(['method'=>'POST','action'=>'ProjectController@children']) !!}

            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group">
                {!! Form::label('name','Название проекта') !!}
                {!! Form::text('name', null, ['class' =>'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('parent','Количество шиносборок') !!}
                {!! Form::select('parent',array(''=>'Количество шиносборок','1'=>'1','2'=>'2','3'=>'3'), null, ['class' =>'form-control']) !!}
            </div>

            {!! Form::submit('Подтвердить', ['class' =>'btn btn-success']) !!}

            {!! Form::close() !!}
            @include('includes.formerror')
        </div>
    </div>





@endsection