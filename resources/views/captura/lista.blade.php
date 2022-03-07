@extends('adminlte::page')

@section('title', 'Dados Capturados')

@section('content_header')
<h1>Dados Capturados</h1>
<small>Listagem das capturas de dados realizadas do site https://www.questmultimarcas.com.br</small>
@stop

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            @csrf
            <table class="table table-sm table-stripped table-hover dataTable">
                <thead>
                    <tr>
                        @foreach ($colunas as $label)
                        <th><strong>{{ $label }}</strong></th>
                        @endforeach
                        <th><strong>Ações</strong></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($carros as $carro)
                    <tr id="tr_{{ $carro->id }}">
                        @foreach (array_keys($colunas) as $coluna)
                        <td @if(!empty($colunas_classes[$coluna])) class="{{ $colunas_classes[$coluna] }}" @endif>
                            @switch($coluna)
                                @case('img')
                                    <img class="img-circle img-sm float-none" alt="Imagem" src="{{ $carro->link_img }}">
                                @break

                                @case('nome_veiculo')
                                    <a href="{{ $carro->link }}" target="_blank">{{ $carro->$coluna ?: "- - -" }}</a>
                                @break

                                @case('preco')
                                    R$ {{ number_format($carro->$coluna, 0, ',', '.') }}
                                @break;

                                @case('quilometragem')
                                    {{ number_format($carro->$coluna, 0, ',', '.') }}
                                @break

                                @default
                                    {{ $carro->$coluna ?: "- - -" }}
                                @break
                            @endswitch
                        </td>
                        @endforeach
                        <td class="text-center">
                            <button type="button" class="btn btn-sm btn-danger btnDelete" data-id="{{ $carro->id }}">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ count($colunas) }}" class="text-center">Nenhum registro encontrado</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop

@section('css')

@stop

@section('js')
<script src="{{ URL::asset('/js/captura/lista.js') }}"></script>
@stop