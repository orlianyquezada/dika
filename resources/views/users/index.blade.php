@extends('adminlte::page')

@section('title', 'Admin - usuarios')

@section('content_header')
<div class="card border-white shadow">
    <div class="card-body">
        <div class="row justify-content-between">
            <div class="col-12 col-lg-3">
                <h3><strong>Users</strong></h3>
            </div>
            <div class="col-12 col-lg-3">
                <a href="{{ route('user.create') }}" class="btn btn-warning shadow-sm w-100"><strong>Registration</strong></a>
            </div>
        </div>
    </div>
</div>
@stop

@section('content')
    <div class="card shadow border-white">
        <div class="card-body">
            <div class="table-responsive">
                <table id="table_users" class="table table-hover">
                    <thead>
                        <th>Usuario</th>
                        <th>Correo</th>
                        <th>Acciones</th>
                    </thead>
                </table>
            </div>
        </div>

    </div>
@stop

@section('css')
    <meta name="_token" content="{{ csrf_token() }}">
    <meta name="url-user" content="{{route('user.index')}}">
@stop

@section('js')
    <script src="{{ asset('js/users/index.js') }}"></script>
@stop   