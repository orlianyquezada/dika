@extends('adminlte::page')
@section('title', 'Conditions')
@section('content_header')
    <!-- Container's info -->
    <div class="container mt-3">
        <!-- Messages alert -->
        @if (session('flash'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('flash') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @else
            <div id="alertSuccess"></div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @else
            <div id="alertDanger"></div>
        @endif
        <div class="card border-white shadow">
            <div class="card-body">
                <div class="row justify-content-between">
                    <div class="col-12 col-lg-3">
                        <h3><strong>Conditions</strong></h3>
                    </div>
                    {{-- 
                    <div class="col-12 col-lg-3">
                        <!-- condtion register button -->
                        <button type="button" class="btn btn-warning shadow-sm w-100" data-toggle="modal" data-target="#insertConditions">
                            <strong>Register</strong>
                        </button>
                    </div>              
                    --}}
                </div>
            </div>
        </div>
    </div>
@stop
@section('content')
    <div class="container">
        <!-- Conditions's table -->
        <div class="card shadow border-white">
           <div class="card-body">
                <table class="table table-hover dt-responsive nowrap display dataTable_width_auto display" id="dtConditions" style="width:100%">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>

        <!-- Modal's insert -->
        <div class="modal fade" id="insertConditions" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="insertConditionsLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title" id="insertConditionsLabel"><strong>Condition Register</strong></h5>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('condition-register') }}" method="post" autocomplete="off" id="conditionRegister">
                            @csrf
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="condition_co" id="name" class="form-control shadow-sm" placeholder="Name">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" form="conditionRegister" class="btn btn-warning">Save</button>
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal's update -->
        <div class="modal fade" id="editCondition" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="editConditionLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title" id="editConditionLabel"><strong>Edit Condition</strong></h5>
                    </div>
                    <div class="modal-body">
                        <form id="updateCondition" autocomplete="off">
                            <input type="hidden" name="id" id="idConditionEdit">
                            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <label for="nameEdit">Name</label>
                                <input type="text" id="nameEdit" name="condition_co" class="form-control shadow-sm">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btnEdit" form="updateCondition" class="btn btn-warning shadow-sm" onclick="updateCondition();">Update</button>
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <style>
        table.dataTable.dataTable_width_auto {
            width: auto;
        }
    </style>
@stop

@section('js')
    <script>
        $(document).ready( function () {
            $('#dtConditions').DataTable({
                responsive: true,
                autoWidth: false,
                ajax:{
                    url: 'all-conditions',
                    method: "GET",
                },
                columns:[
                    {data: 'condition_co'},
                    {width: "10%", orderable: false, data: 'id',
                    render: function(data,t,w,meta){
                        return '<div class="btn-group btn-group-sm justify-content-end" role="group" aria-label=""><button onclick="editCondition('+data+');" class="btn btn-xs btn-ligth text-dark" title="Edit"><i class="fa fa-fw fa-pen"></i></button></div>';
                    }}
                ]
            });
        } );

        function editCondition(idCondition){
            $.ajax({
                type: "GET",
                url: 'consult-condition/'+idCondition,
                success: function(data){
                    $('#nameEdit').val(data.condition_co);
                    $('#idConditionEdit').val(data.id);
                },
                error: function(data){
                    $('#editCondition').modal('hide');
                    $('#alertDanger').html('<div class="alert alert-danger alert-dismissible fade show" role="alert">¡Information not available!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                }
            });
            $('#editCondition').modal('show');
        }

        function updateCondition(){
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
                type: "POST",
                url: 'update-condition/'+$('#idConditionEdit').val(),
                data: $('form#updateCondition').serialize(),
                error: function(data){
                    $('#editCondition').modal('hide');
                    $('#dtConditions').DataTable().ajax.reload();
                    $('#alertDanger').append('<div id="messageAlertDanger"></div>');
                    $('#messageAlertDanger').addClass('alert alert-danger alert-dismissible fade show');
                    $('#messageAlertDanger').append('<ul id="listAlert"></ul>');
                    var resultado = data.responseJSON.errors;
                    var contenido = '';
                    $.each(resultado, function(index, value) {
                        contenido += '<li>'+value+'</li>';
                    });
                    $("#listAlert").html(contenido);
                    $('#messageAlertDanger').append('<button type="button" id="dimissibleAlertDanger" data-dismiss="alert" aria-label="Close"></button>');
                    $('#dimissibleAlertDanger').addClass('close');
                    $('#dimissibleAlertDanger').append('<span aria-hidden="true">&times;</span>');
                },
                success: function(data){
                    if (data == 0){
                        $('#editCondition').modal('hide');
                        $('#alertDanger').append('<div id="messageAlertDanger"></div>');
                        $('#messageAlertDanger').addClass('alert alert-danger alert-dismissible fade show');
                        $('#messageAlertDanger').text('¡That name has another condition');
                        $('#messageAlertDanger').append('<button type="button" id="dimissibleAlertDanger" data-dismiss="alert" aria-label="Close"></button>');
                        $('#dimissibleAlertDanger').addClass('close');
                        $('#dimissibleAlertDanger').append('<span aria-hidden="true">&times;</span>');
                    }else{
                        $('#editCondition').modal('hide');
                        $('#dtConditions').DataTable().ajax.reload();
                        $('#alertSuccess').append('<div id="messageAlertSuccess"></div>');
                        $('#messageAlertSuccess').text('¡The condition has been successfully edited!');
                        $('#messageAlertSuccess').addClass('alert alert-success alert-dismissible fade show');
                        $('#messageAlertSuccess').append('<button type="button" id="dimissibleAlertSuccess" data-dismiss="alert" aria-label="Close"></button>');
                        $('#dimissibleAlertSuccess').addClass('close');
                        $('#dimissibleAlertSuccess').append('<span aria-hidden="true">&times;</span>');
                    }
                }
            });
        }
    </script>
@stop
