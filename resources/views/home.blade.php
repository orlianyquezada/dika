@extends('adminlte::page')

@section('title', 'Home')

@section('content_header')
@stop

@section('content')
    <div class="container text-center">
        <img src="vendor/adminlte/dist/img/DikaLogicticsLogo.png" alt="Logo de Dika Logictics" class="img-circle img-fluid shadow-sm mt-5 pt-4" width="350px">
        <h1 class="mt-3"><strong>Dika Logictics</strong></h1>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
