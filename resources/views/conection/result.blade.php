@extends('layouts.app')
@section('content')


    <div class="container-fluid">
        <h1>Результаты</h1>

        {!! Form::open(['method'=>'POST','action'=>'ConectionController@store']) !!}

        <table class="table table-condensed">
            <thead>
            <tr>
                <th>Id</th>
                <th>Название</th>
                <th>Условное обозначение</th>
                <th>Производитель</th>
                <th>Номинальный ток</th>
                <th>Количество фаз</th>
                <th>Ток отсечки</th>
                <th>Степень защиты</th>
                <th>Время создания</th>
            </tr>
            </thead>

            @if(isset($creates))

                @foreach($creates as $create)
                    <tbody>
                    <tr>
                        <td>{{$create['id']}}</td>
                        <input type="hidden" name="creates[]" value="{{$create['id']}}">
                        <td>{{$create['name']}}</td>
                        <input type="hidden" name="creates[]" value="{{$create['name']}}">
                        <td>{{$create['title']}}</td>
                        <input type="hidden" name="creates[]" value="{{$create['title']}}">
                        <td>{{$create['product']}}</td>
                        <input type="hidden" name="creates[]" value="{{$create['product']}}">
                        <td>{{$create['nominal_current']}}</td>
                        <input type="hidden" name="creates[]" value="{{$create['nominal_current']}}">
                        <td>{{$create['poles']}}</td>
                        <input type="hidden" name="creates[]" value="{{$create['poles']}}">
                        <td>{{$create['break_current']}}</td>
                        <input type="hidden" name="creates[]" value="{{$create['break_current']}}">
                        <td>{{$create['outdoor_protection']}}</td>
                        <input type="hidden" name="creates[]" value="{{$create['outdoor_protection']}}">
                        <input type="hidden" name="creates[]" value="{{$create['project_id']}}">
                        <td>
                            <a href={{route('conection.destroyone', ['delete_id'=>$create['id']])}}>Расчёт нового присоединения</a>
                        </td>
                    </tr>
                    @endforeach



                    </tbody>
                    @endif

        </table>


                <a class="btn btn-primary" href={{route('conection.create' )}} role="button">Расчёт нового присоединения</a>


        {!! Form::submit('Подтвердить', ['class' =>'btn btn-success']) !!}

        {!! Form::close() !!}
    </div>



@stop