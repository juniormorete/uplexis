@extends('app')

@section('content_header')
<h1><b>UpLexis</b> - Teste para Vaga PHP</h1>
@stop

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5 col-xl-4">
            <div class="card">
                <div class="card-header">Recursos Utilizados</div>
                <div class="card-body">
                    <ul>
                        <li><a href="https://www.docker.com/" target="_blank">Docker</a></li>
                        <li><a href="https://hub.docker.com/layers/php/library/php/8.1.3-apache/images/sha256-415e2640074ec2cf9a6b4e659bc10e034a4b5d6f0800285cc0ee4e5ed1f0aaf0?context=explore" target="_blank">Docker Image PHP v{{ phpversion() }}</a></li>
                        <li><a href="https://hub.docker.com/layers/mysql/library/mysql/8.0.18/images/sha256-119ecffb345e201c406e12e203b550aece0dc34671fe19069f00f1825f8d6b98?context=explore" target="_blank">Docker Image MySql v8.0.18</a></li>
                        <li><a href="https://laravel.com/docs/9.x" target="_blank">Laravel v{{ app()->version() }}</a></li>
                        <li><a href="https://github.com/jeroennoten/Laravel-AdminLTE" target="_blank">AdminLTE3 para Laravel</a></li>
                        <li>Plugins:
                            <ul>
                                <li><a href="https://api.jquery.com/" target="_blank">jQuery v3.6.0</a></li>
                                <li><a href="https://getbootstrap.com/docs/4.6/getting-started/introduction/" target="_blank">Boostrap 4</a></li>
                                <li><a href="https://fontawesome.com/" target="_blank">FontAwesome</a></li>
                                <li><a href="https://sweetalert2.github.io/" target="_blank">Sweet Alert 2</a></li>
                                <li><a href="https://adminlte.io/docs/3.0/javascript/toasts.html" target="_blank">Toast</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection