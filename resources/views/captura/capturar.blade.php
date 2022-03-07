@extends('adminlte::page')

@section('title', 'Capturar Dados')

@section('content_header')
<h1>Capturar Dados</h1>
<small>Operação de captura de dados do site https://www.questmultimarcas.com.br</small>
@stop

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    {{ Form::open(['id' => 'frmCaptura', 'url' => 'captura/capturar']) }}
                    <div class="row justify-content-center">
                        <div class="col-md-10 col-lg-8 col-xl-6">
                            <div class="input-group">
                                <input type="text" name="palavra-chave" class="form-control" placeholder="Palavra-Chave" aria-label="Palavra-Chave">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button" title="Capturar dados" id="btnCapturar">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
                <div class="card-body">
                    <div id="divResultado" class="row justify-content-center">
                        <div class="col-auto">Digite uma palavra-chave e dispare a busca por veículos</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
<link rel="stylesheet" href="{{ URL::asset('/css/captura/capturar.css') }}">
@stop

@section('js')
<script src="{{ URL::asset('/js/captura/capturar.js') }}"></script>
@stop