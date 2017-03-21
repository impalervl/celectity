@extends('layouts.app')

@section('content')
    <h1>Количество присоединений на шиносборках</h1>
<div class="container-fluid">
    {!! Form::open(['method'=>'POST','action'=>'ProjectController@start']) !!}

    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    @if($parent == 1)
        <div class="form-group">
            {!! Form::label('section1','Количество присоединений секции 1') !!}
            {!! Form::select('section1',array(''=>'Количество присоединений секции 1','1'=>'1','2'=>'2','3'=>'3'), null, ['class' =>'form-control']) !!}
            <input type="hidden" name="parent" value="1">
            <input type="hidden" name="sections" value="40">
        </div>
    @elseif($parent == 2)
        <div class="form-group">
            {!! Form::label('section1','Количество присоединений секции 1') !!}
            {!! Form::select('section1',array(''=>'Количество присоединений секции 1','1'=>'1','2'=>'2','3'=>'3'), null, ['class' =>'form-control']) !!}
            <input type="hidden" name="parent" value="2">
            <input type="hidden" name="sections" value="40">
        </div>

        <div class="form-group">
            {!! Form::label('section2','Количество присоединений секции 2') !!}
            {!! Form::select('section2',array(''=>'Количество присоединений секции 2','1'=>'1','2'=>'2','3'=>'3'), null, ['class' =>'form-control']) !!}
        </div>
    @elseif($parent == 3)
        <div class="form-group">
            {!! Form::label('section1','Количество присоединений секции 1') !!}
            {!! Form::select('section1',array(''=>'Количество присоединений секции 1','1'=>'1','2'=>'2','3'=>'3'), null, ['class' =>'form-control']) !!}
            <input type="hidden" name="parent" value="3">
            <input type="hidden" name="sections" value="40">
        </div>

        <div class="form-group">
            {!! Form::label('section2','Количество присоединений секции 2') !!}
            {!! Form::select('section2',array(''=>'Количество присоединений секции 2','1'=>'1','2'=>'2','3'=>'3'), null, ['class' =>'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('section3','Количество присоединений секции 3') !!}
            {!! Form::select('section3',array(''=>'Количество присоединений секции 3','1'=>'1','2'=>'2','3'=>'3'), null, ['class' =>'form-control']) !!}
        </div>
    @endif

    {!! Form::submit('Подтвердить', ['class' =>'btn btn-success']) !!}

    {!! Form::close() !!}

    @include('includes.formerror')
</div>

@endsection