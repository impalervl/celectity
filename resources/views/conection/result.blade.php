@extends('layouts.app')
@section('content')

    <h1>Результаты</h1>

    <table class="table table-hover">
        <thead>
        <tr>
            <th>Id</th>
            <th>Проект</th>
            <th>Название</th>
            <th>Условное обозначение</th>
            <th>Производитель</th>
            <th>Номинальный то</th>
            <th>Количество фаз</th>
            <th>Ток отсечки</th>
            <th>Степень защиты</th>
            <th>Время создания</th>
        </tr>
        </thead>
        <tbody>
        @if($create)
            <tr>
                <td>{{$create->id}}</td>
                <td>{{$create->project->name}}</td>
                <td>{{$create->name}}</td>
                <td>{{$create->title}}</td>
                <td>{{$create->product}}</td>
                <td>{{$create->nominal_current}}</td>
                <td>{{$create->poles}}</td>
                <td>{{$create->break_current}}</td>
                <td>{{$create->outdoor_protection}}</td>
                <td>{{$create->created_at}}</td>
            </tr>
        @endif
        </tbody>
    </table>
    {!! Form::open(['method'=>'DELETE','action'=>['ConectionController@destroy',$create->id]]) !!}

    <input type="hidden" name="_token" value="{{ csrf_token() }}">

    <div class="form-group">

        {!! Form::submit('Удалить результат',['class'=>'btn btn-danger']) !!}

    </div>
    {!! Form::close() !!}
@stop