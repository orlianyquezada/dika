@extends('adminlte::page')

@section('title', 'Movements')

@section('content_header')
    <!-- Container's info -->
    <div class="container mt-3">
        <!-- Messages alert -->
        {{-- @if (session('status'))
            <x-adminlte-alert theme="success" title="{{ session('status') }}" dismissable></x-adminlte-alert>
        @endif
        @if ($errors->any())
            <x-adminlte-alert theme="danger" titlle="Error" dismissable>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </x-adminlte-alert>
        @endif --}}
        <div class="card border-white shadow">
            <div class="card-body">
                <div class="row justify-content-between">
                    <div class="col-12 col-lg-3">
                        <h3><strong>Movements</strong></h3>
                    </div>
                    <div class="col-12 col-lg-3">
                        <!-- customer registration button -->
                        <button type="button" class="btn btn-warning shadow-sm w-100" data-toggle="modal" data-target="#insertMovements">
                            <strong>Registration</strong>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container">
        <!-- Modal's insert -->
        <div class="modal fade" id="insertMovements" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="insertMovementsLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="insertMovementsLabel"><strong>Movement Registration</strong></h5>
                    </div>
                    <div class="modal-body">
                        <form action="#" method="post" id="Register">
                            <input type="text" name="_token" value="{{ csrf_token() }}">
                            {{-- <input type="hidden" name="date_mo" id="date" value="@php date_default_timezone_set('America/Caracas'); echo $DateAndTime = date('Y-m-d H:i:s', time()); @endphp "> --}}
                            <input type="hidden" name="user_id" value="1">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" form="Register" class="btn btn-warning">Save</button>
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop