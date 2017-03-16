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
            <th>удалить</th>
        </tr>
        </thead>
        <tbody>
        @if($conections)
            @foreach($conections as $conection)
            <tr>
                <td>{{$conection->id}}</td>
                <td>{{$conection->project->name}}</td>
                <td>{{$conection->name}}</td>
                <td>{{$conection->title}}</td>
                <td>{{$conection->product}}</td>
                <td>{{$conection->nominal_current}}</td>
                <td>{{$conection->poles}}</td>
                <td>{{$conection->break_current}}</td>
                <td>{{$conection->outdoor_protection}}</td>
                <td>{{$conection->created_at}}</td>
                <td>
                    {!! Form::open(['method'=>'DELETE','action'=>['ConectionController@destroy',$conection->id]]) !!}
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        {!! Form::submit('Удалить результат',['class'=>'btn btn-danger']) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
            @endforeach

        </tbody>
    </table>
    @else
        <a href={{route('conection.create')}}>Расчитать первое присоединение</a>
    @endif
@stop