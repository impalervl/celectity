@extends('layouts.app')

@section('content')
    <h1>Форма расчёта для присоединения</h1>

    {!! Form::open(['method'=>'POST','action'=>'ConectionController@store','files'=>true]) !!}

    <input type="hidden" name="_token" value="{{ csrf_token() }}">

    <div class="form-group">
        {!! Form::label('name','Enter Name:') !!}
        {!! Form::text('name', null, ['class' =>'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('electric_user','Тип потребителя') !!}
        {!! Form::select('electric_user',array(''=>'Тип потребителя','1'=>'Асинхронный двигатель','2'=>'Другое'), null, ['class' =>'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('poles','Количество фаз') !!}
        {!! Form::select('poles',array(''=>'Колличество фаз','1'=>'1','2'=>'2','3'=>'3'), null, ['class' =>'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('voltage','Номинальное напряжение(B)') !!}
        {!! Form::select('voltage',array(''=>'Класс напряжения','220'=>'220','380'=>'380'), null, ['class' =>'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('capacity','Номинальная мощность(Вт)') !!}
        {!! Form::text('capacity', null, ['class' =>'form-control']) !!}
    </div>

    {!! Form::submit('Подтвердить', ['class' =>'btn btn-primary']) !!}

    {!! Form::close() !!}


@endsection