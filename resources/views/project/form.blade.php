@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1>Форма расчёта для присоединения{{$title}}</h1>

    {!! Form::open(['method'=>'POST','action'=>'ProjectController@calculate']) !!}

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
    <input type="hidden" name="sec" value="{{$sections--}}">
    <input type="hidden" name="sections" value="{{$sections}}">
    <input type="hidden" name="section3" value="{{$section3}}">
    <input type="hidden" name="section2" value="{{$section2}}">
    <input type="hidden" name="section1" value="{{$section1}}">
    <input type="hidden" name="title" value="{{$title}}">

    @if(isset($cnt1))
        <input type="hidden" name="dfdf" value="{{$cnt1++}}">
        <input type="hidden" name="cnt1" value="{{$cnt1}}">
        @if($cnt1== $section1)
            <input type="hidden" name="sec1" value="{{$parent--}}">
        @endif

    @endif
    @if(isset($cnt2))
        <input type="hidden" name="sec" value="{{$cnt2++}}">
        <input type="hidden" name="cnt2" value="{{$cnt2}}">
        @if($cnt2== $section2)
            <input type="hidden" name="sec1" value="{{$parent--}}">
        @endif

    @endif
    @if(isset($cnt3))
        <input type="hidden" name="sec" value="{{$cnt3++}}">
        <input type="hidden" name="cnt3" value="{{$cnt3}}">
        @if($cnt3== $section3)
            <input type="hidden" name="sec1" value="{{$parent--}}">
        @endif

    @endif
    <input type="hidden" name="parent" value="{{$parent}}">

    {!! Form::submit('Подтвердить', ['class' =>'btn btn-success']) !!}

    {!! Form::close() !!}

    @include('includes.formerror')
</div>

@endsection