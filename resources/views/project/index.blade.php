@extends('layouts.app')
@section('content')

    <div class="container-fluid">
        <ul class="button button-blue">
            <a class="btn btn-primary" href={{route('project.create')}} role="button">Расчёт проекта</a>
        </ul>
    </div>

@stop